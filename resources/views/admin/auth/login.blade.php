@extends('layouts.auth.default')
@section('title', 'Admin login')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">Admin login</h1>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">Login to your account</div>
            <!--end::Subtitle=-->
        </div>
        <admin-login _token="{{csrf_token()}}"></admin-login>
    </div>
</div>
@endsection
