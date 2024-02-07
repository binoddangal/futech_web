@extends('layouts.admin.layout')
@section('content')
    <slider :home-route="{{json_encode(url('/'))}}"></slider>
@endsection
