<?php

namespace App\Services\User\Address;

use App\Http\Resources\User\Address\UserAddressResouce;
use App\Models\User\Address\UserAddress;

class UserAddressService
{
    protected $address;

    public function __construct(
        UserAddress $address)
    {
        $this->address = $address;
    }

    public function paginate($limit = 25, $userId)
    {
        $address = $this->address->whereUserId($userId)->orderBy('id', "DESC")->paginate($limit);
        return UserAddressResouce::collection($address);
    }

    public function store($userId, $data)
    {
        try {
            $data['user_id'] = $userId;
            return $this->address->create($data);
        } catch
        (\Exception $ex) {
            return false;
        }
    }

    public function getById($userId, $id)
    {
        $address = $this->address->whereUserId($userId)->find($id);
        if (!empty($address))
            return new UserAddressResouce($address);
        return null;
    }

    public function update($userId, $id, $data)
    {
        try {
            $address = $this->getById($userId, $id);
            return $address->update($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function delete($userId, $id)
    {
        try {
            $address = $this->getById($userId, $id);
            return $address->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }
    public function createOrUpdate($userId, $data)
    {
        try {
            $address = $this->getByUserAndType($userId,$data['type']);
            if(!empty($address)) {
                return $this->update($userId, $address->id,$data);
            } else {
                return $this->store($userId, $data);
            }
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function getByUserAndType($userId,$type)
    {
        return $this->address->whereUserId($userId)->whereType($type)->first();
    }

    public function findByColumn($userId, $column, $value)
    {
        return $this->address->whereUserId($userId)->where($column, $value)->first();
    }

    public function findByColumns($userId, $data, $limit = 0)
    {
        $result = $this->address->whereUserId($userId)->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if (!empty($limit) || $limit != 0) {
            $result = $result->take($limit)->get();
            return UserAddressResouce::collection($result);
        } else {
            return new UserAddressResouce($result);
        }
    }
}
