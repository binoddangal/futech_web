@extends('layouts.admin.layout')
@section('content')
    <album :home-route="{{json_encode(url('/'))}}"></album>
@endsection
