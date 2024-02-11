<?php

namespace App\Services\Cms\Blog;

use App\Http\Resources\Cms\Blog\BlogResource;
use App\Models\Cms\Blog\Blog;
use App\Services\Service;
use Carbon\Carbon;
use App\Services\Cms\Blog\Category\BlogCategoryService;
use Illuminate\Support\Facades\Hash;

class BlogService extends Service
{

    protected $blog;
    protected $uploadPath = "uploads/blog";

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function paginate( $limit = 25,$data)
    {
        $blog = $this->blog->where(function ($qry) use ($data) {
                if (!empty($data['title']))
                    $qry->where('title', 'like', "%" . $data['title'] . "%");

                if (isset($data['type']) && !empty($data['type']))
                    $qry->whereType($data['type']);

                if (isset($data['category_id']) && !empty($data['category_id']))
                    $qry->whereRaw('FIND_IN_SET(?,category_id)', $data['category_id']);

                if (isset($data['publish_date_from']) && !empty($data['publish_date_from']))
                    $qry->whereDate('publish_date', '>=', Carbon::parse($data['publish_date_from']));

                if (isset($data['publish_date_to']) && !empty($data['publish_date_to']))
                    $qry->whereDate('publish_date', '<=', Carbon::parse($data['publish_date_to']));

                if (isset($data['is_active']) && !empty($data['is_active']))
                    $qry->whereIsActive($data['is_active']);

                if (isset($data['type']) && $data['type'] == 'event' && isset($data['filter_by']) && !empty($data['filter_by'])) {
                    if ($data['filter_by'] == 'upcomming')
                        $qry->whereDate('event_date', '>=', Carbon::now());
                    else
                        $qry->whereDate('event_date', '<=', Carbon::now());
                }
            })->orderBy('id', "DESC")->paginate($limit);
        return BlogResource::collection($blog);
    }

    public function getByType($type, $limit)
    {
        $news = $this->blog->whereType($type)->whereIsActive(1);
        if ($type == "event")
            $news->where->orderBy('publish_date', "DESC");
        else
            $news->orderBy('publish_date', "DESC");
        return BlogResource::collection($news->paginate($limit));
    }

    public function getNewsAndAnnouncement($limit)
    {
        $examinationCategoryId = 12;
        $news = $this->blog->whereType('news')->where('category_id', '!=', $examinationCategoryId)->whereIsActive(1)->orderBy('publish_date', "DESC");
        return BlogResource::collection($news->paginate($limit));
    }

    public function getNewsByCategoryId($id, $limit)
    {
        $news = $this->blog->whereCategoryId($id)->whereIsActive(1)->orderBy('publish_date', "DESC");
        return BlogResource::collection($news->paginate($limit));
    }

    public function getEvents($limit, $all)
    {
        $news = $this->blog
            ->whereType('event')
            ->whereIsActive(1);
        if (!$all) {
            $news = $news->where('event_end', '>=', Carbon::now()->toDateString())->orderBy('publish_date', "ASC")->limit($limit)->get();
        } else {
            $news = $news->orderBy('publish_date', "ASC")->paginate();
        }
        return BlogResource::collection($news);
    }

    public function getBlogs()
    {
        $blogs = $this->blog
            ->whereType('blog')
            ->whereIsActive(1)->orderBy('publish_date', "DESC")->paginate();
        return BlogResource::collection($blogs);
    }

    public function getPastEvent($type, $limit, $resource = true)
    {
        $news = $this->blog->whereIsActive(1)->whereType($type)->whereDate('event_end', '<', Carbon::now()->toDateString())->whereIsActive(1)->orderBy('publish_date', "DESC")->paginate($limit);
        if ($resource)
            return BlogResource::collection($news);
        return $news;
    }

    public function getUpcommingEvent($type, $limit, $resource = true)
    {
        $news = $this->blog->whereIsActive(1)->whereType($type)->where('publish_date', '>=', Carbon::now()->toDateString())->orderBy('publish_date', 'ASC')->paginate($limit);
        if ($resource)
            return BlogResource::collection($news);
        return $news;
    }

    public function getBySlug($slug)
    {
        return $this->blog->whereSlug($slug)->first();
    }


    public function store($data)
    {
//        try {
        if (isset($data['social_share_image_file']) && !empty($data['social_share_image_file'])) {
            $data['social_share_image'] = $this->upload($data['social_share_image_file'], null, null, $this->uploadPath);
        }
        if (isset($data['image_file']) && !empty($data['image_file'])) {
            $data['image'] = $this->upload($data['image_file'], null, null, $this->uploadPath);
        }
        if (isset($data['author_image_file']) && !empty($data['author_image_file'])) {
            $data['author_image'] = $this->upload($data['author_image_file'], null, null, $this->uploadPath);
        }
        if (!empty($data['publish_date'])) {
            $data['publish_date'] = Carbon::create($data['publish_date'])->toDateTimeString();
        }
        if (!empty($data['event_end'])) {
            $data['event_end'] = Carbon::create($data['event_end'])->toDateTimeString();
        }
        return $this->blog->create($data);
//        } catch
//        (\Exception $ex) {
//            return false;
//        }
    }

    public function getById($id)
    {
        $blog = $this->blog->find($id);
        return new BlogResource($blog);
    }

    public function update($id, $data)
    {
//        try {
        $blog = $this->getById($id);
        if (!empty($data['social_share_image'])) {
            if (!empty($blog->social_share_image)) {
                $this->deleteFile($this->uploadPath, $blog->social_share_image);
            }
            $data['social_share_image'] = $this->upload($data['social_share_image'], null, null, $this->uploadPath);
        }

        if (!empty($data['image_file'])) {
            if (!empty($blog->image)) {
                $this->deleteFile($this->uploadPath, $blog->image);
            }
            $data['image'] = $this->upload($data['image_file'], null, null, $this->uploadPath);
        }
        if (!empty($data['author_image_file'])) {
            if (!empty($blog->author_image)) {
                $this->deleteFile($this->uploadPath, $blog->author_image);
            }
            $data['author_image'] = $this->upload($data['author_image_file'], null, null, $this->uploadPath);
        }

        if (!empty($data['publish_date']) && isset($data['publish_date'])) {
            $data['publish_date'] = Carbon::create($data['publish_date'])->toDateTimeString();
        }

        return $blog->update($data);
//        } catch (\Exception $ex) {
//            return false;
//        }
    }

    public function delete($id)
    {
        try {
            $blog = $this->getById($id);
            if (!empty($blog->image)) {
                $this->deleteFile($this->uploadPath, $blog->image);
            }
            return $blog->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->blog->where($column, $value)->first();
    }

    public function getUserForLogin($email, $password)
    {
        $blog = $this->blog->whereEmail($email)->first();
        if (empty($blog))
            return false;

        if (Hash::check($password, $blog->password))
            return $blog;

        return false;
    }

    public function findByColumns($data, $all = false, $resource = true)
    {
        $result = $this->blog->where(function ($query) use ($data) {
            if (sizeof($data) > 0) {
                foreach ($data as $k => $v) {
                    $query->where($k, $data[$k]);
                }
            }
        });
        if ($all) {
            $result = $result->get();
            return $resource ? BlogResource::collection($result) : $result;
        } else {
            $result = $result->first();
            if (empty($result))
                return null;
            return $resource ? new BlogResource($result) : $result;
        }
    }

    public function searchByKey($key, $limit, $limitText = 100)
    {
        $results = $this->blog
            ->where('title', 'like', '%' . $key . '%')
            ->orWhere('content', 'like', '%' . $key . '%')
            ->orWhere('type', 'like', $key . '%')
            ->take($limit)
            ->whereIsActive(1)
            ->orderBy('id', "DESC")
            ->get();
        $blogs = [];
        $news = [];
        $events = [];
        if ($results->count() > 0) {
            foreach ($results as $p) {
                $temp = [
                    'title' => $p->title,
                    'route' => route('blog-detail', $p->slug),
                    'description' => trim(substr($p->content, 0, $limitText)) . "...",
                ];
                if ($p->type = 'blog') {
                    array_push($blogs, $temp);
                } else if ($p->type = 'news') {
                    array_push($news, $temp);
                } else {
                    array_push($events, $temp);
                }
            }
        }
        return [
            $news,
            $blogs,
            $events,
        ];
    }

    public function getUpcomingEventByDay($limit = 25, $type = 'blog', $all = false)
    {
        $todayDate = Carbon::now()->toDateString();
        $blogs = $this->blog->whereIsActive(1)->whereType($type)->whereDate('publish_date', '<=', $todayDate)->orderBy('id', 'DESC')->paginate($limit);
        if($all) {
            return $blogs;
        } else {
            $newBlogs = [];
            if ($blogs->count() > 0) {
                foreach ($blogs as $blog) {
                    $newBlogs[] = (object)[
                        'title' => $blog->title,
                        'image' => $blog->image,
                        'image_path' => $blog->image_path,
                        'author_name' => $blog->author_name,
                        'categories' =>  $blog->categories ? $blog->categories[0]->title : null,
                        'publish_date' => !empty($blog->publish_date) ? formatDate($blog->publish_date) : null,
                        'type' => $blog->type,
                        'url' =>  $blog->type=="blog" ? route('blog.detail', $blog->slug) : route('news.detail', $blog->slug),
                        'content' => $blog->content,
                        'is_active' => $blog->is_active,
                    ];
                }
            }
        }

        return $newBlogs;

    }
}
