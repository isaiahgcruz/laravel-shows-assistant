@extends('layouts.app')

@section('content')
    <shows-page :user="{{ json_encode(Auth::user()) }}"></shows-page>
@endsection
