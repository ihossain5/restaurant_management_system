@extends('layouts.frontend.master')
@section('title')
    Contact Us
@endsection
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/contact-us.css') }}">
    <style>
        .inner-content p >a{
            color: inherit;
        }
    </style>
@endsection
@section('content')
    <section class="contact-us">
        <div class="container">
            <div class="row">
                @if (!empty($restaurants))
                    @foreach ($restaurants as $restaurant)
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="contact-info-wrapper">
                                <img src="{{ asset('images/' . $restaurant->logo) }}" alt="restaurant-logo"
                                    class="restaurant-logo">
                                <div class="inner-content">
                                    <h5>{{ $restaurant->name }}</h5>
                                    <ul>
                                        <li>
                                            <p class="icon">
                                                <img class="img-fluid"
                                                    src="{{ asset('frontend/assets/images/location-mark.svg') }}"
                                                    alt="location" />
                                            </p>
                                            <p class="address">{{ $restaurant->address }}</p>
                                        </li>
                                        <li>
                                            <p class="icon">
                                                <img class="img-fluid"
                                                    src="{{ asset('frontend/assets/images/land-phone.png') }}"
                                                    alt="land-phone" />
                                            </p>
                                            <p>{{ $restaurant->contact }}</p>
                                        </li>
                                        <li>
                                            <p class="icon">
                                                <img class="img-fluid"
                                                    src="{{ asset('frontend/assets/images/email.png') }}" alt="mail-box" />
                                            </p>
                                            <p>{{ $restaurant->email }}</p>
                                        </li>
                                        <li>
                                            <p class="icon">
                                                <img class="img-fluid"
                                                    src="{{ asset('frontend/assets/images/fb.png') }}" alt="mail-box" />
                                            </p>
                                            <p>
                                                <a href="{{ $restaurant->facebook_link}}" target="blank">
                                                    {{ $restaurant->facebook_link ?? 'N/A' }}
                                                </a>
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection
