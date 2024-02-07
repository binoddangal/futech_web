@extends('layouts.admin.layout')
@section('content')
    <testimonial-create :home-route="{{json_encode(url('/'))}}"></testimonial-create>
@endsection
