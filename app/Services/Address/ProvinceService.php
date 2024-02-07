<?php

namespace App\Services\Address;

use App\Http\Resources\Address\ProvinceResource;
use App\Models\Address\Province;

class ProvinceService
{
    protected $province;

    public function __construct(Province $province)
    {
        $this->province = $province;
    }

    public function paginate($limit = 25, $request)
    {
        $districts = $this->province->where(function ($query) use ($request) {
            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }

        })->orderBy('id', 'ASC');

        $districts = $districts->paginate($limit);

        return ProvinceResource::collection($districts);
    }

    public function allProvinces()
    {
        $province = $this->province->whereIsActive(1)->get();
        return ProvinceResource::collection($province);
    }

    public function store($data)
    {

        try {
            $province = $this->province->create($data);
            return new ProvinceResource($province);
        } catch
        (\Exception $ex) {
            return false;
        }
    }


    public function find($id)
    {
        $province = $this->province->find($id);
        if (!empty($province))
            return $province;
        return null;
    }

    public function update($id, $data)
    {
        try {
            $province = $this->find($id);
            if (isset($data['is_parent']) && $data['is_parent'] == 1) {
                $data['parent_id'] = null;
            }
            $province->update($data);
            return $province;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $province = $this->find($id);
            return $province->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->province->where($column, $value)->first();
    }

    public function findByColumns($data = null, $limit = 0)
    {
        $result = $this->province->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if (!empty($limit) || $limit != 0) {
            $result = $result->take($limit);
            return ProvinceResource::collection($result);
        } else {
            return new ProvinceResource($result);
        }
    }

}
