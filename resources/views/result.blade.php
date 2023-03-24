@extends('template.base')

@section('content')
        <h1> Your find shortened url below </h1>

<a href="{{ config('app.url') }}/{{ $shortened }}">

{{ config('app.url') }}/{{ $shortened }}

</a>

@stop