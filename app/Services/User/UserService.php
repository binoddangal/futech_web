<?php

namespace App\Services\User;

use App\Http\Resources\User\UserResource;
use App\Models\User\User;
use App\Services\Service;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserService extends Service
{
    protected $user;
    protected $uploadPath = 'uploads/user';

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserForLogin($email, $password)
    {
        $user = $this->user->where('email', $email)->whereIsActive(1)->first();
        if (empty($user))
            return false;

        if (Hash::check($password, $user->password))
            return $user;

        return false;
    }

    public function paginate($limit = 25, $request)
    {
        $users = $this->user->where(function ($query) use ($request) {
            if ($request->filled('info'))
                $query->where('first_name', 'like', '%' . $request->info . '%')
                    ->orWhere('last_name', 'like', '%' . $request->info . '%')
                    ->orWhere('email', 'like', '%' . $request->info . '%');

            if ($request->filled('status')) {
                $query->whereStatus($request->status);
            }

            if ($request->filled('account_type')) {
                $query->whereAccountType($request->account_type);
            }

            if ($request->filled('mobile')) {
                $query->whereMobile($request->mobile)->orWhere('phone', $request->mobile);
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', "DESC");

        return UserResource::collection($users->paginate($limit));
    }

    public function store($data)
    {
        try {

            $data['password'] = getHashedPassword($data['password']);
            return $this->user->create($data);

        } catch (\Exception $ex) {
            return false;
        }
    }

    public function getAllUser($request)
    {
        $users = $this->user->where(function ($query) use ($request) {
            $query->where('email', 'like', '%' . $request->name . '%')
                ->orWhere('first_name', 'like', '%' . $request->name . '%')
                ->orWhere('last_name', 'like', '%' . $request->name . '%')
                ->orWhere('unique_identifier', 'like', '%' . $request->name . '%');
        })->take(10)->get();

        return UserResource::collection($users);
    }

    public function find($id, $resource = false)
    {
        $user = $this->user->find($id);
        if (!empty($user)) {
            if($resource)
                return new UserResource($user);
            return $user;
        }

        return null;
    }

    public function update($id, $data)
    {
        try {
            $user = $this->find($id);
            if (isset($data['password']))
                $data['password'] = getHashedPassword($data['password']);
            else
                unset($data['password']);

            if (isset($data['file']) && file_exists($data['file'])) {
                $this->deleteFile($this->uploadPath, $user->image);
                $data['image'] = $this->upload($data['file'], null, null, $this->uploadPath);
            }

            $user->update($data);

            return $user;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $date = Carbon::now()->toDateTimeString();
            $user = $this->user->find($id);
            $email = $user->email.'_deleted_'.$date;
            $user->update(['email' => $email]);
            return $user->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }


    public function findByColumn($column, $value)
    {
        return $this->user->where($column, $value)->first();
    }

    public function findByUniqueIidentifier($user)
    {
        $user = $this->user->whereUniqueIdentifier($user)->first();
        if (!empty($user))
            return $user;
        return false;
    }

    public function findByColumns($data = [], $all = false, $resource = true, $limit = 0)
    {
        $result = $this->user->where(function ($query) use ($data) {
            if (sizeof($data) > 0) {
                foreach ($data as $key => $value) {
                    if (!empty($data[$key]))
                        $query->where($key, $data[$key]);
                }
            }
        });
        if ($limit > 0)
            $result = $result->take($limit);
        if ($all) {
            $result = $result->get();
            if ($resource)
                return UserResource::collection($result);
            return $result;
        } else {
            $result = $result->first();
            if ($resource)
                return new UserResource($result);
            return $result;
        }
    }

    public function generateUniqueIidentifier()
    {
        try {
            $random_number = $this->randomNumber();
            if ($random_number)
                while (true) {
                    $uniqueNumber = $this->findByUniqueIidentifier($random_number);
                    if (!$uniqueNumber) {
                        return $random_number;
                    } else {
                        $random_number = $this->randomNumber();
                    }
                }

        } catch (\Exception $ex) {
            return false;
        }
    }

    public function randomNumber()
    {
        $random_number = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, 6);
        return $random_number;
    }

    public function resetPassword($id, $data)
    {
        $user = $this->user->find($id);
        if ($user) {
            $data['password'] = getHashedPassword($data['new_password']);
            $user->update($data);
            return $user;

        } else {
            return false;
        }
    }

    public function checkDuplicateEmail($data)
    {
        $user = $this->user->whereEmail($data['email'])->first();
        if ($user) {
            return 0;
        }
        return true;
    }

    public function checkDuplicateEmailForUpdate($request, $userId)
    {
        $user = $this->user->where('id', '!=', $userId)->whereEmail($request['email'])->first();
        if ($user) {
            return 0;
        }
        return true;
    }

    public function approvedOrRejectedUser($id, $data, $authUser)
    {
        try {
            $user = $this->find($id);
            if(isset($data['status']) && $data['status'] == 'approved') {
                $data['approved_by'] = $authUser->id;
                $user->update($data);
            } else {
                $data['approved_by'] = null;
                $user->update($data);
            }
            return $user;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function updatePassword($id, $data)
    {
        try {
            $user = $this->find($id);
            if (Hash::check($data['current_password'], $user->password)) {
                if (isset($data['autoGenerate']) && $data['autoGenerate'] == 1) {
                    $newPassword = getRandomString(10);
                    $data['password'] = getHashedPassword($newPassword);
                } else {
                    if($data['current_password'] == $data['new_password']){
                        return "SamePasswordAsPrevious";
                    }else{
                        $data['password'] = getHashedPassword($data['new_password']);
                    }
                }
                $user->update(['password' => $data['password']]);
                return $user;
            }
            return "InvalidPassword";
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function getNotifyUserEmails($userIds)
    {
        $users = $this->user->whereIn('id', $userIds)->whereIsActive(1)->get()->pluck('email')->toArray();
        return $users;
    }
}
