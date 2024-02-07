@extends('layouts.admin.layout')
@section('content')
    <faq-category :home-route="{{json_encode(url('/'))}}"></faq-category>
@endsection
