@extends('layouts.admin.layout')
@section('content')
    <album-value :album_id={{ $id }} :home-route="{{json_encode(url('/'))}}"></album-value>
@endsection
