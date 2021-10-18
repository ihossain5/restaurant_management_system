@extends('layouts.frontend.master')
@section('title')
    Menu
@endsection
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/menu.css') }}">
@endsection
@section('content')
    <!-- Menu Page Carousel -->
    <section class="container-fluid p-0">
        <div id="menuCarousel" class="carousel slide hero-carousel menuCarousel" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#menuCarousel" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#menuCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#menuCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
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
    </section>


    <!-- Restaurent Details -->
    <section class="container-fluid restaurent-Details">
        <div class="row">
            <div class="col-12 text-center social-link">
                <a href="#"><img src="{{ asset('frontend/assets/images/Menu/facebook-circular-logo 1.svg') }}" alt=""></a>
                <a href="#"><img src="{{ asset('frontend/assets/images/Menu/instagram 1.svg') }}" alt=""></a>
            </div>
            <div class="col-12 text-center">
                <img class="restaLogo" src="{{ asset('images/' . $restaurant->logo) }}" alt="">
            </div>
            <div class="col-12 restaurSubTitle text-center">
                <p> Delivery available only in Gulshan</p>
            </div>
            <div class="col-12 restaurDetails text-center">
                <p>{{ $restaurant->description }}</p>

                <a id="menu" href="{{route('frontend.about.us')}}#{{$restaurant->restaurant_id}}">Read More</a>
            </div>
        </div>
    </section>
    <!-- Menu -->
    <section class="container-fluid menu-section" >
        <div class="row">
            <div class="col-12">
                <h1 class="menuTitle">Menu</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 d-none d-lg-block">
                <div class="sideCatSticky ">
                    <ul class="sideCategories">
                        @if (!empty($restaurant->restaurant_categories))
                            @foreach ($restaurant->restaurant_categories as $category)
                                @if (count($category->items) > 0)
                                    <li>
                                        <a href="#{{ $category->category_id }}">{{ $category->name }}
                                            ({{ $category->items->count() }})
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="menu-container">
                    @if (!empty($restaurant->restaurant_categories))
                        @foreach ($restaurant->restaurant_categories as $category)
                            <!-- category loop start -->
                            @if (count($category->items) > 0)
                                <div class="row">
                                    <div class="col-12 categories" id="{{ $category->category_id }}">
                                        <h1 class="categoriesTitle">{{ $category->name }}</h1>
                                    </div>
                                </div>
                                <div class="row">
                                    @if (!empty($category->items))
                                        @foreach ($category->items as $item)
                                            <!-- item loop start -->
                                            <!-- item -->
                                            <div class="col-12 col-sm-6 col-md-12 item mb-5">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                @foreach ($item->item_assets->take(1) as $image)
                                                                    <img class="w-100"
                                                                        src="{{ asset('images/' . $image->pivot->asset) }}"
                                                                        alt="">
                                                                @endforeach
                                                            </div>
                                                            <div class="col-md-8 item-content pt-5 pt-md-0">
                                                                <h3>{{ $item->name }}</h3>
                                                                <ul>
                                                                    <li>{{ $item->taste }}</li>
                                                                    <li>{{ $item->volume }}</li>
                                                                </ul>
                                                                <p>{{ $item->description }}.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                                        <h3 class="price">Tk. {{ $item->price }}</h3>
                                                        <button class="cartBtn">Add to Cart</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- item loop end -->
                                    @endif
                                </div>
                            @endif
                        @endforeach
                        <!-- category loop end -->
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
@section('pageScripts')
    <script>
        $(window).scroll(function() {

            var scroll = $(window).scrollTop();
            var deliverSection = $(".restaurent-Details");

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

        // click left menu to add ref element extra padding
        $('.sideCategories a').click(function() {
            var currLink = $(this);
            var refElement = $(currLink.attr("href"));

            if (!refElement.hasClass('active')) {
                $('.categories').removeClass('active');
                refElement.addClass('active');
            }
        });
    </script>
@endsection
