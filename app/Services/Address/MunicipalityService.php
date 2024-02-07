<?php

namespace App\Services\Address;

use App\Http\Resources\Address\MunicipalityResource;
use App\Models\Address\Municipality;

class MunicipalityService
{
    protected $municipality;

    public function __construct(Municipality $municipality)
    {
        $this->municipality = $municipality;
    }

    public function paginate($limit = 25, $request)
    {
        $municipalities = $this->municipality->where(function ($query) use ($request) {
            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }

        })->orderBy('id', 'ASC');

        $municipalities = $municipalities->paginate($limit);

        return MunicipalityResource::collection($municipalities);
    }

    public function municipalitiesByDistrict($districtId)
    {
        $municipalities = $this->municipality->whereDistrictId($districtId)->whereIsActive(1)->get();
        return MunicipalityResource::collection($municipalities);
    }

    public function store($data)
    {

        try {
            $municipality = $this->municipality->create($data);
            return new MunicipalityResource($municipality);
        } catch
        (\Exception $ex) {
            return false;
        }
    }


    public function find($id)
    {
        $municipality = $this->municipality->find($id);
        if (!empty($municipality))
            return $municipality;
        return null;
    }

    public function update($id, $data)
    {
        try {
            $municipality = $this->find($id);
            if (isset($data['is_parent']) && $data['is_parent'] == 1) {
                $data['parent_id'] = null;
            }
            $municipality->update($data);
            return $municipality;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $municipality = $this->find($id);
            return $municipality->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->municipality->where($column, $value)->first();
    }

    public function findByColumns($data = null, $limit = 0)
    {
        $result = $this->municipality->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if (!empty($limit) || $limit != 0) {
            $result = $result->take($limit);
            return MunicipalityResource::collection($result);
        } else {
            return new MunicipalityResource($result);
        }
    }

}
