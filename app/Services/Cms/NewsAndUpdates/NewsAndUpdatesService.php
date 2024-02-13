<?php

namespace App\Services\Cms\NewsAndUpdates;

use App\Http\Resources\Cms\NewsAndUpdates\NewsAndUpdatesResource;
use App\Models\Cms\NewsAndUpdates\NewsAndUpdates;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class NewsAndUpdatesService extends Service
{
    protected $newsAndUpdates;
    protected $uploadPath = "uploads/news-and-updates";

    public function __construct(NewsAndUpdates $newsAndUpdates)
    {
        $this->newsAndUpdates = $newsAndUpdates;
    }

    public function paginate($limit = 25, $request)
    {
        $newsAndUpdates = $this->newsAndUpdates->where(function ($query) use ($request) {
            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->paginate($limit);

        return NewsAndUpdatesResource::collection($newsAndUpdates);
    }

    public function getBySlug($slug)
    {
        return $this->newsAndUpdates->whereSlug($slug)->whereIsActive(1)->first();
    }

    public function frontPaginate($limit = 25)
    {
        $album = $this->newsAndUpdates->orderBy('id', "DESC")->whereIsActive(1)
            ->paginate($limit);
        return NewsAndUpdatesResource::collection($album);
    }

    public function getByType($type, $limit)
    {
        $news = $this->newsAndUpdates->whereType($type)->orderBy('id', "DESC")->paginate($limit);
        return NewsAndUpdatesResource::collection($news);
    }

    public function store($data)
    {
        try {
        if (!empty($data['file'])) {
            $data['social_share_image'] = $this->upload($data['file'], $this->uploadPath);
        }
        return $this->newsAndUpdates->create($data);
           } catch
           (\Exception $ex) {
               return false;
           }
    }


    public function find($newsAndUpdates_id)
    {
        $newsAndUpdates = $this->newsAndUpdates->find($newsAndUpdates_id);
        if (!empty($newsAndUpdates))
            return $newsAndUpdates;
        return null;
    }

    public function update($id, $data)
    {
        // try {
        $newsAndUpdates = $this->find($id);
        if (!empty($data['file'])) {
            if (!empty($newsAndUpdates->social_share_image)) {
                $this->deleteFile($this->uploadPath, $newsAndUpdates->social_share_image);
            }
            $data['social_share_image'] = $this->upload($data['file'], $this->uploadPath);
        }
        // $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == "1") ? 1 : 0;

        return $newsAndUpdates->update($data);;
        // } catch (\Exception $ex) {
        //     return false;
        // }
    }

    public function delete($id)
    {
        try {
            $newsAndUpdates = $this->find($id);
            if (!empty($newsAndUpdates->social_share_image)) {
                $this->deleteFile($this->uploadPath, $newsAndUpdates->social_share_image);
            }
            return $newsAndUpdates->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->newsAndUpdates->where($column, $value)->first();
    }


    public function findByColumns($data = null, $limit = 0)
    {
        $result = $this->newsAndUpdates->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if (!empty($limit) || $limit != 0) {
            $result = $result->take($limit);
            return NewsAndUpdatesResource::collection($result);
        } else {
            return new NewsAndUpdatesResource($result);
        }
    }

    public function getAllActive()
    {
        $newsandupdates = $this->newsAndUpdates->whereIsActive(1)->get();
        return  NewsAndUpdatesResource::collection($newsandupdates);
    }
}
