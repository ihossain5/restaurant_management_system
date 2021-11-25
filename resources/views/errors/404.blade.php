{{-- @extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found')) --}}
@extends('layouts.frontend.master')
@section('title')
    404
@endsection
@section('pageCss')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/404.css') }}">
@endsection
@section('content')
<section class="not-found-section">
    <div class="container">
        <div class="not-found-content">
            <div class="not-found-inner">
                <img src="{{asset('frontend/assets/images/404.png')}}" alt="404" class="img-fluid">
                <h4>Error 404: Page not found</h4>
            </div>
        </div>
    </div>
</section>

@include('layouts.frontend.partials.location_modal')

@endsection
