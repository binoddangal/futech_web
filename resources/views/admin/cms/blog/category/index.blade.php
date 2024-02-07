@extends('layouts.admin.layout')
@section('content')
    <blog-category :home-route="{{json_encode(url('/'))}}"></blog-category>
@endsection
