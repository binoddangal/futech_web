<?php

namespace App\Services\Cms\Download\Type;

use App\Http\Resources\Cms\Download\Type\DownloadTypeResoruce;
use App\Models\Cms\Download\Type\DownloadType;
use App\Services\Service;

class DownloadTypeService extends Service
{
    protected $type;

    public function __construct(
        DownloadType $type
    )
    {
        $this->type = $type;
    }

    public function paginate($limit = 25)
    {
        $type = $this->type->orderBy('id', "DESC")->paginate($limit);
        return DownloadTypeResoruce::collection($type);
    }

    public function getActive()
    {
        $type = $this->type->whereIsActive(1)->orderBy('id', "DESC")->get();
        return DownloadTypeResoruce::collection($type);
    }

    public function store($data)
    {
        try {
            return $this->type->create($data);
        } catch
        (\Exception $ex) {
            return false;
        }
    }

    public function getById($id)
    {
        $type = $this->type->find($id);
        if (!empty($type))
            return new DownloadTypeResoruce($type);
        return null;
    }

    public function update($id, $data)
    {
        try {
            $type = $this->getById($id);
            return $type->update($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $type = $this->getById($id);
            if (!empty($type->path))
                $this->deleteUploaded($this->uploadPath, $type->path);
            return $type->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->type->where($column, $value)->first();
    }

    public function findByColumns($data, $limit = 0)
    {
        $result = $this->type->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if (!empty($limit) || $limit != 0) {
            $result = $result->take($limit)->get();
            return DownloadTypeResoruce::collection($result);
        } else {
            return new DownloadTypeResoruce($result);
        }
    }
}
