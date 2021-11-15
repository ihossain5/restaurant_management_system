@extends('layouts.frontend.master')
@section('title')
    About Us
@endsection

@section('pageCss')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <style>
        .about-section p {
            font-weight: 300;
            font-size: 2rem;
            line-height: 3.8rem;
            color: #383838;
            font-family: 'Roboto', sans-serif;
        }
        .logo-wrapper img{
            width: 120px;
        }

    </style>
@endsection
@section('content')
    <!-- About Us -->
    <section class="container-fluid about-hero">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-1 order-2">
                <img class="emerald-black-logo"
                    src="{{ asset('frontend/assets/images/About Us/Logos/Emerald Group.svg') }}" alt="Emerald Black Logo">
                <p>{{ $about->description }}</p>
            </div>
            <div class="col-lg-6 order-lg-2 order-1">
                <img class="w-100" src="{{ asset('images/' . $about->pic) }}" alt="about hero">
            </div>
        </div>
    </section>

    <section class="aboutHeroLogo">
        <div class="row company-logo">
            @if (!empty($restaurants))
                @foreach ($restaurants as $restaurant)
                    <div class="col-4 col-lg-2">
                        <div class="logo-wrapper">
                            <a href="#{{ $restaurant->restaurant_id }}" class="d-block">
                                <img src="{{ asset('images/' . $restaurant->logo) }}" alt="Thai Emerald">
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
    @if (!empty($restaurants))
        @foreach ($restaurants as $restaurant)
            @if ($loop->odd)
                <!-- Left Img -->
                <section class="about-section container-fluid right-content" id="{{ $restaurant->restaurant_id }}">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="left-box">
                                <div id="carosel{{ $restaurant->restaurant_id }}" class="carousel slide"
                                    data-bs-ride="carousel" data-bs-touch="true">
                                    <div class="carousel-indicators aboutCarouselIndicator">
                                        @if (!empty($restaurant->images))
                                            @foreach ($restaurant->images as $key => $asset)
                                                <button type="button"
                                                    data-bs-target="#carosel{{ $restaurant->restaurant_id }}"
                                                    data-bs-slide-to="{{ $key }}"
                                                    class="{{ $key == 0 ? 'active' : '' }}" aria-current="true"
                                                    aria-label="Slide {{ $loop->iteration }}"></button>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="carousel-inner">
                                        @if (!empty($restaurant->images))
                                            @foreach ($restaurant->images as $key => $asset)
                                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}  ">
                                                    <img src="{{ asset('images/' . $asset) }}" class=" d-block w-100"
                                                        alt="...">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-box">
                                <div class="indCompLogo">
                                    <img src="{{ asset('images/' . $restaurant->logo) }}" alt="">
                                </div>
                                <p class="compDescrip">{!! $restaurant->description !!}</p>
                                <a class="brand-btn-sm"
                                    href="{{ route('frontend.restaurant.menu', [$restaurant->restaurant_id]) }}#menu">View
                                    Menu</a>
                            </div>
                        </div>
                    </div>
                </section>
            @else
                <!-- Right Img -->
                <section class="about-section section-bg container-fluid left-content"
                    id="{{ $restaurant->restaurant_id }}">
                    <div class="row align-items-center">

                        <div class="col-lg-6 order-2 order-lg-1">
                            <div class="left-box">
                                <div class="indCompLogo">
                                    <img src="{{ asset('images/' . $restaurant->logo) }}"
                                        alt="">
                                </div>
                                <p class="compDescrip">{!! $restaurant->description !!}</p>
                                <a class="brand-btn-sm"
                                    href="{{ route('frontend.restaurant.menu', [$restaurant->restaurant_id]) }}#menu">View
                                    Menu</a>
                            </div>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2">
                            <div class="right-box">
                                <div id="carosel{{ $restaurant->restaurant_id }}" class="carousel slide"
                                    data-bs-ride="carousel" data-bs-touch="true">
                                    <div class="carousel-indicators aboutCarouselIndicator">
                                        @if (!empty($restaurant->images))
                                            @foreach ($restaurant->images as $key => $asset)
                                                <button type="button"
                                                    data-bs-target="#carosel{{ $restaurant->restaurant_id }}"
                                                    data-bs-slide-to="{{ $key }}"
                                                    class="{{ $key == 0 ? 'active' : '' }}" aria-current="true"
                                                    aria-label="Slide {{ $loop->iteration }}"></button>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="carousel-inner">
                                        @if (!empty($restaurant->images))
                                            @foreach ($restaurant->images as $key => $asset)
                                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}  ">
                                                    <img src="{{ asset('images/' . $asset) }}" class=" d-block w-100"
                                                        alt="...">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
    @endif
    @include('layouts.frontend.partials.location_modal')
@endsection
@section('pageScripts')
    <script>
        var locationModal = new bootstrap.Modal(document.getElementById('location-modal'), {
            keyboard: false
        })

        locationID = document.getElementById("select_id").value;
        if (locationID != '') {
            $('.lmbCloseBtn').show();
        } else {
            locationModal.show();
        }
    </script>
@endsection
