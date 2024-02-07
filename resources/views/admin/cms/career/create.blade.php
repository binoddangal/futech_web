@extends('layouts.admin.layout')
@section('content')
    <career-create-or-edit :home-route="{{json_encode(url('/'))}}"></career-create-or-edit>
@endsection
