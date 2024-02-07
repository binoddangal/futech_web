@extends('layouts.admin.layout')
@section('content')
    <menu-item :home-route="{{json_encode(url('/'))}}" :menu_id="'{{ $menu_id }}'"></menu-item>
@endsection
