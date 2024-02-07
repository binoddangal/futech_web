@extends('layouts.admin.layout')
@section('content')
    <download :home-route="{{json_encode(url('/'))}}"></download>
@endsection
