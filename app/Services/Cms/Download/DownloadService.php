<?php

namespace App\Services\Cms\Download;

use App\Http\Resources\Cms\Download\DownloadResource;
use App\Models\Cms\Download\Download;
use App\Services\Service;

class DownloadService extends Service
{
    protected $download;

    protected $uploadPath = "uploads/downloads";

    public function __construct(Download $download)
    {
        $this->download = $download;
    }

    public function paginate($data, $limit = 25)
    {
        $download = $this->download->orderByRaw('CAST(position AS SIGNED) ASC')->where(function ($query) use ($data) {
            if (isset($data['title']) && !empty($data['title'])) {
                $query->where('title', 'like', "%" . $data['title'] . "%");
            }
            if (isset($data['type']) && !empty($data['type'])) {
                $query->where('download_type_id', $data['type']);
            }

            if (isset($data['active']) && !empty($data['active'])) {
                $flag = $data['active'] == "active" ? 1 : 0;
                $query->whereIsActive($flag);
            }
        })->paginate($limit);
        return DownloadResource::collection($download);
    }

    public function getByType($type, $limit = 25)
    {
        $download = $this->download->whereType($type)->orderByRaw('CAST(position AS SIGNED) ASC')->paginate($limit);
        return DownloadResource::collection($download);
    }

    public function store($data)
    {
        try {
            if (isset($data['file'])) {
                $data['path'] = $this->upload($data['file'], null, null, $this->uploadPath);
            }
            if (isset($data['image'])) {
                $data['preview_image'] = $this->upload($data['image'], null, null, $this->uploadPath);
            }
            $data['is_private']  = (isset($data['is_private']) && ($data['is_private'] == 1 || $data['is_private'] == true))?1:0;
            $data['is_active']  = (isset($data['is_active']) && ($data['is_active'] == 1 || $data['is_active'] == true))?1:0;
            $data['public_hidden']  = (isset($data['public_hidden']) && ($data['public_hidden'] == 1 || $data['public_hidden'] == true))?1:0;
            return $this->download->create($data);
        } catch
        (\Exception $ex) {
            return false;
        }
    }

    public function sort($data)
    {
        try {
            if (sizeof($data) > 0) {
                foreach ($data as $i => $id) {
                    $download = $this->download->whereId($id)->first();
                    if (!empty($download)) {
                        $v['position'] = ($i + 1);
                        $download->update($v);
                    }
                }
            }
            return true;
        } catch
        (\Exception $ex) {
            return $ex;
        }
    }

    public function getById($id)
    {
        $download = $this->download->find($id);
        if (!empty($download))
            return new DownloadResource($download);
        return null;
    }

    public function update($id, $data)
    {
       try {
        $data['is_private']  = (isset($data['is_private']) && ($data['is_private'] == 1 || $data['is_private'] == true))?1:0;
        $data['is_active']  = (isset($data['is_active']) && ($data['is_active'] == 1 || $data['is_active'] == true))?1:0;
        $data['public_hidden']  = (isset($data['public_hidden']) && ($data['public_hidden'] == 1 || $data['public_hidden'] == true))?1:0;
        $download = $this->getById($id);
        if (isset($data['path'])) {
            if (!empty($download->path)) {
                $this->deleteUploaded($this->uploadPath, $download->path);
            }
            $data['path'] = $this->upload($data['path'], null, null, $this->uploadPath);
        }
        if (isset($data['preview_image'])) {
            if (!empty($download->preview_image)) {
                $this->deleteUploaded($this->uploadPath, $download->preview_image);
            }
            $data['preview_image'] = $this->upload($data['preview_image'], null, null, $this->uploadPath);
        }
        return $download->update($data);
       } catch (\Exception $ex) {
           return false;
       }
    }

    public function delete($id)
    {
        try {
            $download = $this->getById($id);
            if (!empty($download->path))
                $this->deleteUploaded($this->uploadPath, $download->path);
            if (!empty($download->preview_image))
                $this->deleteUploaded($this->uploadPath, $download->preview_image);
            return $download->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->download->where($column, $value)->first();
    }

    public function findByColumns($data, $all = false)
    {
        $response = $this->download->where(function ($query) use ($data) {
            if (sizeof($data) > 0) {
                foreach ($data as $k => $v) {
                    $query->where($k, $data[$k]);
                }
            }
        });
        if ($all) {
            return DownloadResource::collection($response->get());
        } else {
            $response = $response->first();
            if (empty($response))
                return null;
            return new DownloadResource($response);
        }
    }

    public function searchByKey($key, $limit)
    {
        $results = $this->download->where(function ($qry) use ($key) {
            if (!in_array($key, ['down', 'download', 'downloads']))
                $qry->where('title', 'like', '%' . $key . '%');
        })
            ->take($limit)
            ->whereIsActive(1)
            ->orderBy('id', "DESC")
            ->get();
        $albums = [];
        if ($results->count() > 0) {
            foreach ($results as $p) {
                $url = "/uploads/downloads/" . $p->slug;
                $temp = [
                    'title' => $p->title,
                    'route' => url($url)
                ];
                array_push($albums, $temp);
            }
        }
        return $albums;
    }
}
