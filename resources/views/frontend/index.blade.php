@extends('layouts.frontend.master')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/home.css') }}">
    <style>
        .restaurant-status-txt {
            font-family: "Roboto", sans-serif;
            font-style: italic;
            font-weight: 300;
            font-size: 1.8rem;
            line-height: 3rem;
            text-align: center;
            color: #DE973D;
        }

    </style>
@endsection
@section('title')
    Home
@endsection

@section('content')
    <!-- Home Page Carousel -->
    <section class="container-fluid p-0">
        <div id="homeCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
            @if (count($sliders) > 1)
                <div class="carousel-indicators">
                    @if (!empty($sliders))
                        @foreach ($sliders as $key => $slider)
                            <button type="button" data-bs-target="#homeCarousel"
                                data-bs-slide-to="{{ $slider->slider_id }}" class="{{ $key == 0 ? 'active' : '' }}"
                                aria-current="true" aria-label="{{ $slider->slider_id }}"></button>
                        @endforeach
                    @endif
                </div>
            @endif
            <div class="carousel-inner">
                @if (!empty($sliders))
                    @foreach ($sliders as $key => $slider)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ asset('images/' . $slider->pic) }}" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-md-block">
                                <h1>{{ $slider->description }}</h1>
                                <a href="{{route('frontend.about.us')}}">Order Now!</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
    </section>
    <!-- Choose we Deliver -->
    <section class="deliverSection">
        <div class="row pb-5">
            <div class="col-12">
                <h1 class="homeTitle">YOU CHOOSE. WE DELIVER</h1>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-5">
            @if (!empty($restaurants))
                @foreach ($restaurants as $restaurant)
                    <div class="col">
                        <a href="{{ route('frontend.restaurant.menu', [$restaurant->restaurant_id]) }}">
                            <div class="card h-100 deliverCard">
                                <div
                                    class="card-overlay-box  {{ $restaurant->disable == true ? 'disable-overlay' : '' }} restaurantId{{ $restaurant->restaurant_id }}">
                                    <img src="{{ asset('images/' . $restaurant->asset) }}" class="card-img-top"
                                        alt="...">
                                    <div class="card-overlay-content">
                                        <div class="card-ovelay-inner">
                                            <img src="{{ 'images/' . $restaurant->logo }}" alt="">
                                            {{-- <p>**Delivery available only in 
                                                @foreach ($restaurant->delivery_locations as $location)
                                                {{ $lrestaurant->location->name }} @if (!$loop->last),@endif 
                                              @endforeach
                                            </p> --}}
                                            <p>**Delivery available only in 
                                                {{ $restaurant->location }} 
        
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $restaurant->name }}</h5>
                                    <h6>{{ $restaurant->type }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
    <!-- Carousel -->
    <section class="container-fluid deals-section">
        <div class="deals-section-header">
            <div class="row pb-5">
                <div class="col-md-6">
                    <h2 class="carouselTitle">Website-exclusive Offers</h2>
                </div>
                <div class="col-md-6 text-start text-md-end">
                    <div class="dots-div dots d-none dealsDot">
                    </div>
                </div>
            </div>
        </div>
        <div class="owl-carousel deals-carousel">
            @if (!empty($combos))
                @foreach ($combos as $combo)
                    <div>
                        <div class="card dealsCard">
                            <div class="overlayDealsBox">
                                <img src="{{ asset('images/' . $combo->photo) }}" class="card-img-top" alt="...">
                                <div class="overlayDealsBtn">
                                    View Platter Items
                                    <div class="overlayDealsContent">
                                        <div class="cardContent">
                                            @if (!empty($combo->items))
                                                @foreach ($combo->items as $item)
                                                    <h5>{{ $item->name }}</h5>
                                                @endforeach
                                            @endif
                                            <h2>Tk. {{ $combo->price }}</h2>
                                            @if ($combo->disable == true)
                                                <p class="restaurant-status-txt">Delivery is not available in your selected area.</p>
                                            @elseif($combo->closed == true)
                                                <p class="restaurant-status-txt">Restaurant is closed now</p>
                                            @else
                                                <button
                                                    onclick="addToCart({{ $combo->combo_id }},{{ $combo->restaurant_id }},{{ $combo->combo_id }})"
                                                    class=" {{ $combo->disable == true ? 'addTocart' : 'cartBtn' }}  {{ $combo->closed == true ? 'd-none' : ' ' }}  addTocartBtnId{{ $combo->restaurant_id }}">Add
                                                    to Cart</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6>{{ $combo->restaurant->name }}</h6>
                                <h3>{{ $combo->name }}</h3>
                                <h2 class="comboBtn">Tk. {{ $combo->price }}</h2>
                                @if ($combo->disable == true)
                                    <p class="restaurant-status-txt">Delivery is not available in your selected area.</p>
                                @elseif($combo->closed == true)
                                    <p class="restaurant-status-txt">Restaurant is closed now</p>
                                @else
                                    <button
                                        onclick="addToCart({{ $combo->combo_id }},{{ $combo->restaurant_id }},{{ $combo->combo_id }})"
                                        class=" {{ $combo->disable == true ? 'addTocart' : 'cartBtn' }}  {{ $combo->closed == true ? 'd-none' : ' ' }}  addTocartBtnId{{ $combo->restaurant_id }}">Add
                                        to Cart</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
    <!-- Popular Dishes -->
    <section class="container-fluid popular-dishes">
        <div class="popular-section-header">
            <div class="row pb-5">
                <div class="col-md-6">
                    <h2 class="carouselTitle">Customer Favourites</h2>
                </div>
                <div class="col-md-6 text-start text-md-end">
                    <div class="dots-div2 dots popularDot d-none">

                    </div>
                </div>
            </div>
        </div>
        <div class="owl-carousel popular-carousel">
            @if (!empty($order_items))
                @foreach ($order_items as $item)
                    @if (count($item->orders) > 0)
                        <div>
                            <div class="card dealsCard">
                                @foreach ($item->item_assets->take(1) as $image)
                                    <img src="{{ asset('images/' . $image->pivot->asset) }}" class="card-img-top"
                                        alt="...">
                                @endforeach
                                <div class="card-body">
                                    <h6>{{ $item->category->restaurant->name }}</h6>
                                    <h3>{{ $item->name }}</h3>
                                    <h2 class="itemBtn">Tk. {{ $item->price }}</h2>
                                    @if ($item->disable == true)
                                        <p class="restaurant-status-txt">Delivery is not available in your selected area.</p>
                                    @elseif($item->closed == true)
                                        <p class="restaurant-status-txt">Restaurant is closed now</p>
                                    @else
                                        <button
                                            class="{{ $item->disable == true ? 'addTocart' : 'cartBtn' }} addTocartBtnId{{ $item->category->restaurant->restaurant_id }}"
                                            onclick="addToCart({{ $item->item_id }},{{ $item->category->restaurant->restaurant_id }})">Add
                                            to Cart</button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </section>
    @include('layouts.frontend.partials.location_modal')
@endsection
@section('pageScripts')
    <script>
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            var deliverSection = $(".deliverSection");
            var deliverPosition = deliverSection.offset().top;
            if (scroll > deliverPosition - 150) {
                $('.bg-dark-custom').css({
                    "background-color": "#383838"
                })

            } else {
                $('.bg-dark-custom').css({
                    "background-color": "transparent"
                })

            }
        });

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
