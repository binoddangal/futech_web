@extends('layouts.admin.layout')
@section('content')
    <faq :home-route="{{json_encode(url('/'))}}"></faq>
@endsection
