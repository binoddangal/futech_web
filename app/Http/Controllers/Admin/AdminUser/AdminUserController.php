<?php

namespace App\Http\Controllers\Admin\AdminUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUser\AdminUserRequest;
use App\Services\AdminUser\AdminUserService;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    protected $adminUser;

    public function __construct(AdminUserService $adminUser)
    {
        $this->adminUser = $adminUser;
    }

    public function indexView($user_type)
    {
       return view('admin.admin-user.index', compact('user_type'));
    }

    public function viewProfile()
    {
       return view('admin.admin-user.profile.account-security');
    }

    public function index(Request $request)
    {
        $adminUser = auth()->user();
        return $this->adminUser->paginate(20, $request, $adminUser);
    }

    public function getByUserType($userType, Request $request)
    {
        return $this->adminUser->getByUserType($userType, $request);
    }

    public function store(AdminUserRequest $request)
    {
        $adminUser = $this->adminUser->store($request->all());
        if ($adminUser) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);
    }

    public function show($id)
    {
        $adminUser = $this->adminUser->find($id);

        if ($adminUser)
            return response(['status' => "OK" ,'adminUser' => $adminUser], 200);
        return response(['status' => 'ERROR'], 200);
    }

    public function update(Request $request, $id)
    {
        $adminUser = $this->adminUser->update($id, $request->all());
        if ($adminUser)
            return response(['status' => "OK"], 200);

        return response(['status' => 'ERROR' ], 200);
    }

    public function destroy($id)
    {
        if ($this->adminUser->delete($id)) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);
    }

    public function changePassword(Request $request, $id)
    {
        $user = $this->adminUser->updatePassword($id, $request->all(), auth()->user()->id);

        if ($user)
            if ($user != 'InvalidPassword') {
                return response(['status' => "OK", 'url' => route('admin.logout')], 200);
            } else {
                return response(['message' => "InvalidPassword"], 200);
            }

        return response(['status' => 'ERROR', 'errors' => 'Problem occurred.'], 500);
    }
}
