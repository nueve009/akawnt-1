@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include('partials.hero')
    @include('partials.stats')
    @include('partials.about')
    @include('partials.careers')
    @include('partials.contact')
@endsection