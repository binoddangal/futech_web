@extends('layouts.admin.layout')
@section('content')
    <blog-create-or-edit :home-route="{{json_encode(url('/'))}}"></blog-create-or-edit>
@endsection
