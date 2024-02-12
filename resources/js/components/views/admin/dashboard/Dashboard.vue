<template>

    <div>
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Toolbar-->
                <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                    <!--begin::Toolbar container-->
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <!--begin::Title-->
                            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">
                                    <a href="/admin/dashboard" class="text-muted text-hover-primary">Home</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">Dashboards</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->
                    </div>
                    <!--end::Toolbar container-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Content-->

                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
            <!--begin::Footer-->

            <!--end::Footer-->
        </div>
        <!--end:::Main-->
    </div>
</template>
<script>
import DashboardService from '@/services/admin/dashboard/DashboardService';

const dashboard = new DashboardService();
export default {
    name: 'Dashboard',
    data() {
        return {
            requests: [],
            adminUserCount: 0,
            blogCount: 0,
            contactUsCount: 0,
            teamCount: 0,
            noticeCount: 0,
        }
    },
    mounted() {
        this.getDashboardStat();
    },
    methods: {
        getDashboardStat() {
            dashboard.getStats().then(response => {
                this.adminUserCount = response.data.adminUserCount;
                this.blogCount = response.data.adminUserCount;
                this.contactUsCount = response.data.adminUserCount;
                this.teamCount = response.data.adminUserCount;
                this.noticeCount = response.data.adminUserCount;
            })
        }
    },
};
</script>

<style>
</style>
