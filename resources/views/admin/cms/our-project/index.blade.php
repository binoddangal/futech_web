@extends('layouts.admin.layout')
@section('content')
    <our-project :home-route="{{ json_encode(url('/')) }}"></our-project>
@endsection
