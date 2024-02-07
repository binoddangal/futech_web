@extends('layouts.admin.layout')
@section('content')
    <admin-user :user_type="'{{ $user_type }}'"></admin-user>
@endsection
