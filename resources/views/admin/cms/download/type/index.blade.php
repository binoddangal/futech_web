@extends('layouts.admin.layout')
@section('content')
    <download-type :home-route="{{json_encode(url('/'))}}"></download-type>
@endsection
