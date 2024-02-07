@extends('layouts.admin.layout')
@section('content')
    <news-and-updates-create-or-edit :home-route="{{json_encode(url('/'))}}"></news-and-updates-create-or-edit>
@endsection
