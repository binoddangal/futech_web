@extends('layouts.admin.layout')
@section('content')
    <site-setting :home-route="{{json_encode(url('/'))}}"></site-setting>
@endsection
