@extends('layouts.admin.layout')
@section('content')
    <email-template-edit :id="'{{ $id }}'" :home-route="{{json_encode(url('/'))}}"></email-template-edit>
@endsection
