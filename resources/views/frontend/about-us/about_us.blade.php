@extends('layouts.frontend.master')
@section('title')
    About Us
@endsection
@section('content')
    <!-- About Us -->
    <section class="container-fluid about-hero">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-1 order-2">
                <img class="emerald-black-logo" src="{{ asset('frontend/assets/images/About Us/Logos/Emerald Group.svg') }}"
                    alt="Emerald Black Logo">
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
                            <a href="#{{$restaurant->restaurant_id}}" class="d-block">
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
                <section class="about-section container-fluid right-content" id="{{$restaurant->restaurant_id}}">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="left-box">
                                <div id="emeraldCarousel" class="carousel slide" data-bs-ride="carousel"
                                    data-bs-touch="true">
                                    <div class="carousel-indicators aboutCarouselIndicator">
                                        <button type="button" data-bs-target="#emeraldCarousel" data-bs-slide-to="0"
                                            class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#emeraldCarousel" data-bs-slide-to="1"
                                            aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#emeraldCarousel" data-bs-slide-to="2"
                                            aria-label="Slide 3"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        @if (!empty($restaurant->assets))
                                            @foreach ($restaurant->assets as $key => $asset)
                                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }} ">
                                                    <img src="{{ asset('images/' . $asset->pivot->asset) }}" class=" d-block w-100" alt="...">
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
                                    <img src="{{asset('images/'.$restaurant->logo)}}" alt="">
                                </div>
                                <p class="compDescrip">Thai Emerald is all about their warmth, familiarity and the
                                    ability to hold
                                    people back into their
                                    cosiness. From having a strong origin of Thai food culture to chefs from Thailand, the
                                    restaurant
                                    has managed to strike a perfect balance between the authentic ambience and a carefree
                                    unostentatious
                                    environment.

                                    <br>
                                    <br>

                                    Starting from the menu to one’s favourite table, it locks a sense of familiarity with
                                    every
                                    visit.
                                    It also allows people to experience the best of both worlds in terms of a fine dine-out
                                    of a
                                    three-course meal along with the relaxed drawing-room conversations.
                                    <br>
                                    <br>

                                    In short, it’s a place where one will always come back.
                                </p>

                                <a class="brand-btn-sm" href="{{route('frontend.restaurant.menu',[$restaurant->restaurant_id])}}#menu">View Menu</a>
                            </div>
                        </div>
                    </div>
                </section>
            @else
                <!-- Right Img -->
                <section class="about-section section-bg container-fluid left-content" id="{{$restaurant->restaurant_id}}">
                    <div class="row align-items-center">

                        <div class="col-lg-6 order-2 order-lg-1">
                            <div class="left-box">
                                <div class="indCompLogo">
                                    <img style="max-width: 12.2rem;" src="{{asset('images/'.$restaurant->logo)}}" alt="">
                                </div>
                                <p class="compDescrip">The sudden rays of sunlight peeking through the bamboo trees and
                                    the calm
                                    surrounding the little zen garden in our shaded balcony are stories in themselves;
                                    stories of
                                    bringing Japanese inspirations to life. A story through which old traditions were
                                    revisited and
                                    newer traditions were born.
                                    <br><br>
                                    Kiyoshi is where we thrive by merging the old with the new.
                                    <br><br>
                                    Guided by a love for Japanese art and artistry, Kiyoshi was brought to life. Moments
                                    spent here
                                    have been forever etched into our memories; memories of the stillness of nature and
                                    great, great
                                    company.
                                </p>

                                <a class="brand-btn-sm" href="{{route('frontend.restaurant.menu',[$restaurant->restaurant_id])}}#menu">View Menu</a>
                            </div>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2">
                            <div class="right-box">

                                <div id="kioshiCarousel" class="carousel slide" data-bs-ride="carousel"
                                    data-bs-touch="true">
                                    <div class="carousel-indicators aboutCarouselIndicator">
                                        <button type="button" data-bs-target="#kioshiCarousel" data-bs-slide-to="0"
                                            class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#kioshiCarousel" data-bs-slide-to="1"
                                            aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#kioshiCarousel" data-bs-slide-to="2"
                                            aria-label="Slide 3"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        @if (!empty($restaurant->assets))
                                            @foreach ($restaurant->assets as $i => $asset)
                                            <div class="carousel-item {{ $i == 0 ? 'active' : '' }} ">
                                                <img src="{{ asset('images/' . $asset->pivot->asset) }}" class=" d-block w-100" alt="...">
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
@endsection
