@extends('layouts.admin.layout')
@section('content')
    <menus :home-route="{{json_encode(url('/'))}}"></menus>
@endsection
