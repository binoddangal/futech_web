@extends('layouts.admin.layout')
@section('content')
    <contact :home-route="{{json_encode(url('/'))}}"></contact>
@endsection
