<!--begin::Javascript-->
<script type="text/javascript" src=" {{ config('app.env') == 'local' ? asset('js/app.js') : secure_asset('js/app.js') }}"></script>

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('resources/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('resources/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
