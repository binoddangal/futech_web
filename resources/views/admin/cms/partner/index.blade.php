@extends('layouts.admin.layout')
@section('content')
    <partner :home-route="{{ json_encode(url('/')) }}"></partner>
@endsection
