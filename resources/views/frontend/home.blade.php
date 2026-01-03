@extends('frontend.layouts.app')

@section('content')

    @include('frontend.sections.hero')
    @include('frontend.sections.stats')
    @include('frontend.sections.tracks')
    @include('frontend.sections.schedule')
    @include('frontend.sections.faq')
    @include('frontend.sections.news')

@endsection
