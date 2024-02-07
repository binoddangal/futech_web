<?php

namespace App\Services\Address;

use App\Http\Resources\Address\DistrictResource;
use App\Models\Address\District;

class DistrictService
{
    protected $district;

    public function __construct(District $district)
    {
        $this->district = $district;
    }

    public function paginate($limit = 25, $request)
    {
        $districts = $this->district->where(function ($query) use ($request) {
            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }

        })->orderBy('id', 'ASC');

        $districts = $districts->paginate($limit);

        return DistrictResource::collection($districts);
    }

    public function getDistrictsByProvince($provinceId)
    {
        $districts = $this->district->whereProvinceId($provinceId)->whereIsActive(1)->get();
        return DistrictResource::collection($districts);
    }

    public function store($data, $user)
    {

        try {
            $district = $this->district->create($data);
            return new DistrictResource($district);
        } catch
        (\Exception $ex) {
            return false;
        }
    }


    public function find($id)
    {
        $district = $this->district->find($id);
        if (!empty($district))
            return $district;
        return null;
    }

    public function update($id, $data, $user)
    {
        try {
            $district = $this->find($id);
            if (isset($data['is_parent']) && $data['is_parent'] == 1) {
                $data['parent_id'] = null;
            }
            $district->update($data);
            return $district;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $district = $this->find($id);
            return $district->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->district->where($column, $value)->first();
    }

    public function findByColumns($data = null, $limit = 0)
    {
        $result = $this->district->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if (!empty($limit) || $limit != 0) {
            $result = $result->take($limit);
            return DistrictResource::collection($result);
        } else {
            return new DistrictResource($result);
        }
    }

}
