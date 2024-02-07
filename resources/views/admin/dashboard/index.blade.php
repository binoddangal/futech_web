@extends('layouts.admin.layout')
@section('content')
    <admin-dashboard user="{{json_encode(auth()->guard('admin')->user())}}" _token="{{csrf_token()}}"></admin-dashboard>

@endsection
