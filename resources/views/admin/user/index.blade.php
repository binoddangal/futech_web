@extends('layouts.admin.layout')
@section('content')
    <user :status="'{{ $status }}'"></user>
@endsection
