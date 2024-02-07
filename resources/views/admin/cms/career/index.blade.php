@extends('layouts.admin.layout')
@section('content')
    <career :home-route="{{json_encode(url('/'))}}"></career>
@endsection
