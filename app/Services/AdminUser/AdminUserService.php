<?php

namespace App\Services\AdminUser;

use App\Http\Resources\AdminUser\AdminUserResource;
use App\Models\AdminUser\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminUserService
{
    protected $adminUser;

    public function __construct(AdminUser $adminUser)
    {
        $this->adminUser = $adminUser;
    }

    public function paginate($limit = 25, $request, $adminUser)
    {
        $users = $this->adminUser->where(function ($query) use ($request) {

                if ($request->filled('name')){
                    $query->where('username', 'like', '%' . $request->name . '%')
                        ->orWhere('first_name', 'like', '%' . $request->name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->name . '%')
                        ->orWhere('email', 'like', '%' . $request->name . '%');
                }

                if ($request->filled('user_type')) {
                    $query->whereUserType($request->user_type);
                }

                if ($request->filled('is_active')) {
                    $query->whereIsActive($request->is_active);
                }
            })->orderBy('id', "DESC");

        $users = $users->whereNotIn('id', [$adminUser->id])->paginate($limit);

        return AdminUserResource::collection($users);
    }

    public function getByUserType($userType, $request)
    {
        $adminUsers = $this->adminUser->whereIsActive(1)->where(function ($query) use ($request) {

                if ($request->filled('name')){
                    $query->where('username', 'like', '%' . $request->name . '%')
                        ->orWhere('first_name', 'like', '%' . $request->name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->name . '%')
                        ->orWhere('email', 'like', '%' . $request->name . '%');
                }
            })->orderBy('id', "DESC");

        $adminUsers = $adminUsers->whereUserType($userType)->take(10)->get();

        return AdminUserResource::collection($adminUsers);
    }

    public function all()
    {
        $adminUsers = $this->adminUser->whereIsActive(1)->get();
        return AdminUserResource::collection($adminUsers);
    }

    public function store($data)
    {
        try {
            $data['password'] = getHashedPassword($data['password']);
            $adminUser = $this->adminUser->create($data);
            return new AdminUserResource($adminUser);
        } catch
        (\Exception $ex) {
            return false;
        }
    }


    public function find($userId,$resource = true)
    {
        $adminUser = $this->adminUser->find($userId);
        if ($adminUser){
            return $resource ? new AdminUserResource($adminUser) :$adminUser;
        }
        return null;
    }

    public function update($id, $data)
    {
       try {
            $adminUser = $this->find($id);
            if($adminUser->is_mfa_enable == 0 && isset($data['is_email_authentication_enabled']) && !$data['is_email_authentication_enabled']) {
                $data['mfa_secret_code'] = null;
                $data['mfa_authentication_image'] = null;
            }
            return $adminUser->update($data);
       } catch (\Exception $ex) {
           return false;
       }
    }

    public function delete($id)
    {
        try {
            $adminUser = $this->find($id);
            return $adminUser->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->adminUser->where($column, $value)->first();
    }
    public function findByColumns($data = [], $all = false, $resource = true, $limit = 0)
    {
        $result = $this->adminUser->where(function ($query) use ($data) {
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
                return AdminUserResource::collection($result);
            return $result;
        } else {
            $result = $result->first();
            if ($resource)
                return new AdminUserResource($result);
            return $result;
        }
    }


    public function getUserForLogin($email, $password)
    {
        $adminUser = $this->adminUser->whereEmail($email)->orWhere('username', $email)->first();
        if (empty($adminUser))
            return false;

        if (Hash::check($password, $adminUser->password))
            return $adminUser;

        return false;
    }

    public function updatePassword($id, $data, $authUserId)
    {
        try {
            $adminUser = $this->find($id);
            if (Hash::check($data['current_password'], $adminUser->password)) {
                if (isset($data['autoGenerate']) && $data['autoGenerate'] == 1) {
                    $newPassword = getRandomString(10);
                    $data['password'] = getHashedPassword($newPassword);
                } else {
                    if($data['current_password'] == $data['new_password']){
                        return "sa";
                    }else{
                        $data['password'] = getHashedPassword($data['new_password']);
                    }
                }
                $adminUser->update(['password' => $data['password']]);
                // ChangeAdminUserPasswordMailJob::dispatch($newPassword, $adminUser, $authUserId);
                return $adminUser;
            }
            return "InvalidPassword";
        } catch (\Exception $ex) {
            return false;
        }
    }
}
