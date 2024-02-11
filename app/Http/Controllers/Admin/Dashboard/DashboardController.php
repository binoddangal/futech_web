<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\AdminUser\AdminUserService;
use App\Services\Cms\Blog\BlogService;
use App\Services\Cms\ContactUs\ContactUsService;
use App\Services\Cms\Notice\NoticeService;
use App\Services\Cms\Team\TeamService;

class DashboardController extends Controller
{
    protected $adminUser;
    protected $blog;
    protected $contactUs;
    protected $team;
    protected $notice;

    public function __construct(
        AdminUserService $adminUser,
        BlogService $blog,
        ContactUsService $contactUs,
        TeamService $team,
        NoticeService $notice
    ) {
        $this->adminUser = $adminUser;
        $this->blog = $blog;
        $this->contactUs = $contactUs;
        $this->team = $team;
        $this->notice = $notice;
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
        $blogCount = $this->blog->findByColumns(['is_active' => 1], true);
        $contactUsCount = $this->contactUs->findByColumns([], true);
        $teamCount = $this->team->findByColumns(['is_active' => 1], true);
        $noticeCount = $this->notice->findByColumns(['is_active' => 1], true);
        return response([
            'adminUserCount' => $adminUserCount->count(),
            'blogCount' => $blogCount->count(),
            'contactUsCount' => $contactUsCount->count(),
            'teamCount' => $teamCount->count(),
            'noticeCount' => $noticeCount->count(),
        ]);
    }
}
