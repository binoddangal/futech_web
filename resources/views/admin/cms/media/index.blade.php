@extends('layouts.admin.layout')
@section('content')
    <media :home-route="{{json_encode(url('/'))}}"></media>
@endsection
