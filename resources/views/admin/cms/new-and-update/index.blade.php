@extends('layouts.admin.layout')
@section('content')
    <news-and-updates :home-route="{{json_encode(url('/'))}}"></news-and-updates>
@endsection
