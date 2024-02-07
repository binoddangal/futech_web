@extends('layouts.admin.layout')
@section('content')
    <testimonial :home-route="{{json_encode(url('/'))}}"></testimonial>
@endsection
