<?php

namespace App\Providers;

use App\Models\Cms\Notice\Notice;
use App\Models\Cms\SiteSetting\SiteSetting;
use App\Models\User\User;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->getNotices();
        $this->getUserStatus();
        $this->getUserAccountType();
        $this->getSiteSetting();
    }

    private function getNotices() {
        view()->composer('layouts.default.header', function ($view) {
            $notices = Notice::query()->whereIsActive(1)->get();
            $view->with([
                'notices' => $notices,
            ]);
        });
    }

    private function getSiteSetting() {
        view()->composer('layouts.default.header', function ($view) {
            $setting = SiteSetting::query()->first();
            $view->with([
                'setting' => $setting,
            ]);
        });
        view()->composer('layouts.default.footer', function ($view) {
            $setting = SiteSetting::query()->first();
            $view->with([
                'setting' => $setting,
            ]);
        });
    }

    private function getUserStatus() {
        view()->composer('layouts.admin.nav', function ($view) {
            $pending_user_count = User::query()->whereIsActive(1)->whereStatus('pending')->get();
            $approved_user_count = User::query()->whereIsActive(1)->whereStatus('approved')->get();
            $view->with([
                'pending_user_count' => $pending_user_count->count(),
                'approved_user_count' => $approved_user_count->count(),
            ]);
        });
    }

    private function getUserAccountType() {
        view()->composer('layouts.admin.nav', function ($view) {
            $beneficiaries_user_count = User::query()->whereIsActive(1)->whereAccountType('beneficiary')->whereStatus('approved')->get();
            $pharmaceutical_company_user_count = User::query()->whereIsActive(1)->whereAccountType('pharmaceutical_company')->whereStatus('approved')->get();
            $funding_organisation_user_count = User::query()->whereIsActive(1)->whereAccountType('funding_organisation')->whereStatus('approved')->get();
            $volunteer_user_count = User::query()->whereIsActive(1)->whereAccountType('volunteer')->whereStatus('approved')->get();
            $view->with([
                'beneficiaries_user_count' => $beneficiaries_user_count->count(),
                'pharmaceutical_company_user_count' => $pharmaceutical_company_user_count->count(),
                'funding_organisation_user_count' => $funding_organisation_user_count->count(),
                'volunteer_user_count' => $volunteer_user_count->count(),
            ]);
        });
    }
}
