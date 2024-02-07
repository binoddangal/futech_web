@extends('layouts.admin.layout')
@section('content')
    <testimonial-edit :id="{{ $id }}" :home-route="{{json_encode(url('/'))}}"></testimonial-edit>
@endsection
