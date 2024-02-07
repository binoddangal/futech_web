@extends('layouts.admin.layout')
@section('content')
    <blog-list :home-route="{{json_encode(url('/'))}}"></blog-list>
@endsection
