@include('layouts.admin.header')
@include('layouts.admin.nav')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_main" class="app-main flex-column flex-row-fluid">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="app">
             @yield('content')
             <vue-confirm-dialog></vue-confirm-dialog>
             <vue-snotify></vue-snotify>
            </div>
        </div>
        </div>
    </div>
</div>
<div id="kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">{{date('Y')}}&copy; futech</span>
            <a href="https://yelko.com" target="_blank" class="text-gray-800 text-hover-primary">Powered by Yelko</a>
        </div>
        <!--end::Copyright-->
    </div>
    <!--end::Footer container-->
</div>
@include('layouts.admin.footer')

