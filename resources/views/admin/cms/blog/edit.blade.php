@extends('layouts.admin.layout')
@section('content')
    <blog-create-or-edit :id="{{ $id }}" :home-route="{{json_encode(url('/'))}}"></blog-create-or-edit>
@endsection
