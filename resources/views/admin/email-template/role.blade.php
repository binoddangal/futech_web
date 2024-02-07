@extends('layouts.admin.layout')
@section('content')
    <email-template-role :home-route="{{json_encode(url('/'))}}"></email-template-role>
@endsection
