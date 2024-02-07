<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\AdminUser\AdminUserService;
use App\Services\User\UserService;

class DashboardController extends Controller
{
    protected $user;
    protected $adminUser;

    public function __construct(UserService $user, AdminUserService $adminUser) {
        $this->user = $user;
        $this->adminUser = $adminUser;
    }

    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function accountSecurity()
    {
        return view('admin.profile.account-security');
    }

    public function getStats()
    {
        $adminUserCount = $this->adminUser->findByColumns(['is_active' => 1], true);
        $pendingUserCount = $this->user->findByColumns(['is_active' => 1, 'status' => 'pending'], true);
        $completeUserCount = $this->user->findByColumns(['is_active' => 1, 'status' => 'approved'], true);
        $rejectedUserCount = $this->user->findByColumns(['is_active' => 1, 'status' => 'rejected'], true);
        return response([
            'adminUserCount' => $adminUserCount->count(),
            'pendingUserCount' => $pendingUserCount->count(),
            'completeUserCount' => $completeUserCount->count(),
            'rejectedUserCount' => $rejectedUserCount->count(),
        ]);
    }
}
