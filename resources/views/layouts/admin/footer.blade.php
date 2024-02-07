</div>
<!--end::Content wrapper-->
<!--end::Footer-->
</div>
<!--end:::Main-->
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>

<!--begin::Global Javascript Bundle(used by all pages)-->
<script type="text/javascript" src=" {{ config('app.env') == 'local' ? asset('js/app.js') : secure_asset('js/app.js') }}"></script>
<script src="{{ asset('resources/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('resources/js/scripts.bundle.js') }}"></script>
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ asset('resources/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('resources/plugins/custom/vis-timeline/vis-timeline.bundle.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js')}}"></script>
<!--end::Vendors Javascript-->

@include('layouts.required-js')
</body>

</html>
