@extends('layouts.admin.layout')
@section('content')
    <admin-account-security :user-id="{{json_encode(auth()->guard('admin')->user()->id)}}" _token="{{csrf_token()}}"></admin-account-security>
@endsection
