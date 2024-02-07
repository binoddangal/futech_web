<?php

namespace App\Services\User\Verification;

use App\Models\User\Verification\UserVerification;

class UserVerificationService
{
    protected $userVerification;

    function __construct(UserVerification $userVerification)
    {
        $this->userVerification = $userVerification;
    }

    public function create(array $data)
    {
        try {
        return $this->userVerification->create($data);

        } catch (\Exception $e) {
            return $e;
        }
    }
    public function paginate(array $filter = [])
    {
        $filter['limit'] = 25;
        return $this->userVerification->paginate($filter['limit']);
    }

    public function find($id)
    {
        try {
            return $this->userVerification->find($id);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function update($id, array $data)
    {
        try {
            $state = $this->find($id);
            return $state->update($data);

        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $userVerification = $this->find($id);
            return $userVerification->delete();
        } catch (\Exception $e) {
            return false;
        }
    }
    public function findByColumn($columnName, $value)
    {

        return $this->userVerification->where($columnName, $value)->first();
    }

    public function findByColumns($columnNames, $values)
    {
        return $this->userVerification->where(function ($query) use ($columnNames, $values) {
            foreach ($columnNames as $columnName) {
                if (!empty($values[$columnName]))
                    $query->where($columnName, $values[$columnName]);
            }
        })->first();
    }

    public function findVerificationByColumns($data)
    {
        return $this->userVerification->where(function ($query) use ($data) {
            foreach ($data as $key => $datum) {
                if (!empty($data[$key]))
                    $query->where($key, $data[$key]);
            }
        })->first();
    }

    public function generateToke()
    {
        return rand(111111, 999999);
    }

    public function completeToken($value, $token, $type)
    {
        try {
        $tokens = $this->userVerification->whereNotIn('token', [$token])->whereValue($value)->whereType($type)->get();
        if ($tokens->count() > 0) {
            foreach ($tokens as $token) {
                $token->update(['is_used' => 1]);
            }
        }
        return true;
        } catch (\Exception $ex) {
            return false;
        }
    }
}
