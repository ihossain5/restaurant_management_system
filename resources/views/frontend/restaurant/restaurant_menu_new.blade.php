@extends('layouts.frontend.master')
@section('title')
    Menu
@endsection
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('frontend/assets/OwlCarousel2-2.3.4/assets/owl.carousel.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">

    <style>
        .restaurant-status p{
            font-family: "Roboto", sans-serif;
            font-style: italic;
            font-weight: 300;
            font-size: 1.8rem;
            line-height: 3rem;
            /* text-align: center; */
            color: #DE973D;
        }

    </style>
@endsection
@section('content')
    <!-- Menu Page Carousel -->
    @if (!empty($images))
        <section class="container-fluid p-0 manu-page-hero">
            <div id="menuCarousel" class="carousel slide hero-carousel menuCarousel" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach ($images as $key => $image)
                        <button type="button" data-bs-target="#menuCarousel" data-bs-slide-to="{{ $key }}"
                            class="{{ $key == 0 ? 'active' : '' }}" aria-current="true"
                            aria-label="Slide {{ $loop->iteration }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach ($images as $key => $image)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }} ">
                            <img src="{{ asset('images/' . $image) }}" class=" d-block w-100" alt="...">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- Restaurent Details -->
    <section class="container-fluid restaurent-Details">
        <div class="row">
            <div class="col-12 text-center social-link">
                <a href="{{ $restaurant->facebook_link}}"  target="_blank"><img src="{{ asset('frontend/assets/images/Menu/facebook-circular-logo 1.svg') }}" alt=""></a>
                <a href="#"><img src="{{ asset('frontend/assets/images/Menu/instagram 1.svg') }}" alt=""></a>
            </div>
            <div class="col-12 text-center">
                <img class="restaLogo" src="{{ asset('images/' . $restaurant->logo) }}" alt="">
            </div>
            <div class="col-12 restaurSubTitle text-center">
                @if ($restaurant->restaurant_status_id != null && $restaurant->status->name == 'CLOSED')
                    <p>Restaurant is closed now</p>
                @else
                    <p>
                        Delivery available only in  {{ $restaurant->location }} 
                         {{-- @foreach ($restaurant_locations as $location)
                          {{ $location }} @if (!$loop->last),@endif 
                        @endforeach --}}
                    </p>
                @endif
                {{-- <p> {{ $restaurant->restaurant_status_id == null ? '' : ($restaurant->status->name == 'CLOSED' ? 'Restaurant is closed now' : 'Delivery available only in Gulshan') }}
                </p> --}}
            </div>
            <div class="col-12 restaurDetails text-center">
                <p>{!! $restaurant->description !!}</p>
                <a id="menu" href="{{ route('frontend.about.us') }}#{{ $restaurant->restaurant_id }}">Read More</a>
            </div>
        </div>
    </section>

    <section class="menu-title-wrapper">
        <div class="container">
            <h1 class="menuTitle">Menu</h1>
        </div>
    </section>

    <section class="menu-navbar-wrapper sticky-top">
        <div class="container">
            <div id="menuNavbar" class="">
                <ul class="scroll-x-navbar nav-pills sideCategories owl-carousel">
                    @if (!empty($restaurant->restaurant_categories))
                        @foreach ($restaurant->restaurant_categories as $category)
                            @if (count($category->available_items) > 0)
                                <li class="nav-item">
                                    <a href="#category{{ $category->category_id }}"
                                        class="nav-link">{{ $category->name }}
                                        ({{ $category->available_items->count() }})</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </section>


    <section class="scrollspy-menu-content">
        <div class="container menuContainer">
            @if (!empty($restaurant->restaurant_categories))
                @foreach ($restaurant->restaurant_categories as $category)
                    <!-- category loop start -->
                    @if (count($category->available_items) > 0)
                        <div class="row categories" id="category{{ $category->category_id }}">
                            <div class="categories-active-height"></div>
                            <h1 class="categoriesTitle">{{ $category->name }}</h1>
                            <!-- item if condition start -->
                            @if (!empty($category->available_items))
                                <!-- item loop start -->
                                @foreach ($category->available_items as $item)
                                    <div class="col-12 menuItem">
                                        <div class="row">
                                            <div class="col-4 col-md-2">
                                                @foreach ($item->item_assets->take(1) as $image)
                                                    <img class="w-100"
                                                        src="{{ asset('images/' . $image->pivot->asset) }}" alt="">
                                                @endforeach
                                            </div>
                                            <div class="col-8 col-md-10 item-content">
                                                <div>
                                                    <h3>{{ $item->name }}</h3>
                                                    <ul>
                                                        <li>{{ $item->taste }}</li>
                                                        <li>{{ $item->volume }}</li>
                                                    </ul>
                                                    <p>{{ $item->description }}.</p>
                                                </div>

                                                <div class="restaurant-status">
                                                    <h3 class="price">Tk. {{ currency_format($item->price) }}
                                                    </h3>
                                                    @if ($restaurant->disable == true)
                                                        <p class="restaurant-status-txt">Delivery is not available in your selected area.</p>
                                                    @elseif($restaurant->status->name == 'CLOSED')
                                                        <p class="restaurant-status-txt">Restaurant is closed now</p>
                                                    @else
                                                        <button
                                                            class="{{ $restaurant->disable == true ? 'addTocart' : 'cartBtn' }}  {{ $restaurant->status->name == 'CLOSED' ? 'd-none' : ' ' }}   menuCartBtn  addTocartBtnId{{ $item->category->restaurant->restaurant_id }}"
                                                            onclick="addToCart({{ $item->item_id }},{{ $item->category->restaurant->restaurant_id }})">Add
                                                            to Cart
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- item loop end -->
                            @endif
                            <!-- item if condition end -->
                        </div>
                    @endif
                @endforeach
                <!-- category loop end -->
            @endif
        </div>
    </section>

    @include('layouts.frontend.partials.location_modal')
@endsection
@section('pageScripts')
    <script src="{{ asset('frontend/assets/js/jquery.mousewheel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/OwlCarousel2-2.3.4/owl.carousel.min.js') }}"></script>
    <script>
        $('.body').attr('data-bs-spy', 'scroll');
        $('.body').attr('data-bs-target', '#navbarMenu');
        $('.body').attr('data-bs-offset', '200');
        $('.body').attr('tabindex', '0');


        // $(window).scroll(function() {
        //     var scroll = $(window).scrollTop();
        //     var deliverSection = $(".restaurent-Details");

        //     var deliverPosition = deliverSection.offset().top;

        //     if (scroll > deliverPosition - 150) {
        //         $('.bg-dark-custom').css({
        //             "background-color": "#383838"
        //         })
        //     } else {
        //         $('.bg-dark-custom').css({
        //             "background-color": "transparent"
        //         })
        //     }
        // });

        // click left menu to add ref element extra padding
        $('.sideCategories a').click(function() {
            var currLink = $(this);
            var refElement = $(currLink.attr("href"));

            if (!refElement.hasClass('active')) {
                $('.categories').removeClass('active');
                refElement.addClass('active');
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





        $(document).ready(function() {
            //main navbar background color toggle
            $(window).scroll(function() {
                let windowTop = $(window).scrollTop();
                let mainNavbarHeight = $('.navbar').innerHeight();
                let totalScrollTop = windowTop + mainNavbarHeight;
                var heroSection = $(".manu-page-hero").innerHeight();
                if (totalScrollTop > heroSection) {
                    $('.bg-dark-custom').css({
                        "background-color": "#383838"
                    })
                } else {
                    $('.bg-dark-custom').css({
                        "background-color": "transparent"
                    })
                }
            });

            // menu page menu item navigation fixed when scroll top 0
            $(window).scroll(function() {
                const navbarHeight = $('.navbar').innerHeight();
                $('.menu-navbar-wrapper.sticky-top').css('top', `${parseFloat(navbarHeight - 2)}px`);
            });

            //click top menu to add ref element extra padding
            $('.sideCategories a').click(function(e) {
                let currLink = $(this);
                let refElement = $(currLink.attr("href"));
                if (!refElement.hasClass('active')) {
                    $('.categories').removeClass('active');
                    refElement.addClass('active');
                }
            });

            // onwhell category active class remove 
            $(window).on('wheel', function() {
                $('.categories').removeClass('active');
            });

            //scrollspy int
            $(window).on('activate.bs.scrollspy', function(e) {

            });

            //menunav int
            var owl = $('.scroll-x-navbar');
            owl.owlCarousel({
                loop: false,
                nav: true,
                dots: false,
                margin: 10,
                autoWidth: true,
                responsive: {
                    0: {
                        items: 3,
                        nav: false
                    },
                    576: {
                        items: 5
                    },
                    960: {
                        items: 7
                    },
                    1200: {
                        items: 9
                    }
                }
            });
        });
    </script>
@endsection
