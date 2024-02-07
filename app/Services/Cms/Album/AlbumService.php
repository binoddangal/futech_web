<?php

namespace App\Services\Cms\Album;

use App\Http\Resources\Cms\Album\AlbumResource;
use App\Models\Cms\Album\Album;
use App\Services\Service;
use Illuminate\Support\Facades\Hash;

class AlbumService extends Service
{
    protected $album;
    protected $uploadPath = "uploads/album";

    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    public function paginate($limit = 25, $request)
    {
        $album = $this->album->where(function ($qry) use ($request) {
            if ($request->filled('title')) {
                $qry->where('title', 'like', "%" . $request->title . "%");
            }
            if ($request->filled('is_active')) {
                $qry->whereIsActive($request->is_active);
            }
        })->orderBy('position', "ASC")->paginate($limit);
        return AlbumResource::collection($album);
    }

    public function paginateFront($limit = 25)
    {
        $album = $this->album->orderBy('position', "DESC")->whereIsActive(1)->paginate($limit);
        return AlbumResource::collection($album);
    }

    public function sort($id, $index)
    {
        try {
            $album = $this->album->find($id);
            if (!empty($album))
                $album->update(['position' => $index]);

            $otherAlbums = $this->album->where('id', '!=', $id)->orderBy('position', "asc")->get();
            if ($otherAlbums->count() > 0) {
                $position = 0;
                foreach ($otherAlbums as $i => $album) {
                    $position = ($i + 1);
                    if ($position >= $index)
                        $position = $index + ($i + 1);
                    $album->update(['position' => $position]);
                }
            }
        } catch
        (\Exception $ex) {
            return $ex;
        }
    }

    public function frontPaginate($limit = 25)
    {
        $album = $this->album->orderBy('id', "DESC")->whereIsActive(1)
            ->paginate($limit);
        return AlbumResource::collection($album);
    }

    public function getByType($type, $limit)
    {
        $news = $this->album->whereType($type)->orderBy('id', "DESC")->paginate($limit);
        return AlbumResource::collection($news);
    }

    public function getBySlug($slug)
    {
        return $this->album->whereSlug($slug)->first();
    }

    public function store($data)
    {
        try {
            $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == true) ? true : 0;
            if (isset($data['file']) && !empty($data['file'])) {
                $data['cover_image'] = $this->upload($data['file'], null, null, $this->uploadPath);
            }
            return $this->album->create($data);
        } catch
        (\Exception $ex) {
            return false;
        }
    }

    public function getById($id)
    {
        $album = $this->album->whereId($id)->first();
        return new AlbumResource($album);
    }

    public function update($id, $data)
    {
        try {
            $album = $this->getById($id);
            if (!empty($data['cover_image'])) {
                if (!empty($album->cover_image)) {
                    $this->deleteFile($this->uploadPath, $album->cover_image);
                }
                $data['cover_image'] = $this->upload($data['cover_image'], null, null, $this->uploadPath);
            }
            $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == "1") ? 1 : 0;
            return $album->update($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $album = $this->getById($id);
            if (!empty($album->cover_image)) {
                $this->deleteFile($this->uploadPath, $album->cover_image);
            }
            return $album->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->album->where($column, $value)->first();
    }

    public function getUserForLogin($email, $password)
    {
        $album = $this->album->whereEmail($email)->first();
        if (empty($album))
            return false;

        if (Hash::check($password, $album->password))
            return $album;

        return false;
    }

    public function findByColumns($data, $all = false)
    {
        $response = $this->album->where(function ($query) use ($data) {
            if (sizeof($data) > 0) {
                foreach ($data as $k => $v) {
                    $query->where($k, $data[$k]);
                }
            }
        });
        if ($all) {
            return AlbumResource::collection($response->orderBy('id', 'DESC')->get());
        } else {
            $response = $response->first();
            if (empty($response))
                return null;
            return new AlbumResource($response);
        }
    }

    public function searchByKey($key, $limit)
    {
        $results = $this->album
            ->where('title', 'like', '%' . $key . '%')
            ->orWhereRaw('FIND_IN_SET(?,tags)', [$key])
            ->take($limit)
            ->whereIsActive(1)
            ->orderBy('id', "DESC")
            ->get();
        $albums = [];
        if ($results->count() > 0) {
            foreach ($results as $p) {
                $temp = [
                    'title' => $p->title,
                    'img' => $p->cover_image_path['thumb'],
                    'route' => route('gallery-detail', $p->slug)
                ];
                array_push($albums, $temp);
            }
        }
        return $albums;
    }

    public function getAllActive(){
        $albumGallery = $this->album->whereIsActive(1)->get();
        return  AlbumResource::collection($albumGallery);
    }

   
}
