@extends('layouts.frontend.master')
@section('title')
    Menu
@endsection
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
@endsection
@section('content')
    <!-- Menu Page Carousel -->
    @if (!empty($images))
        <section class="container-fluid p-0">
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
                <a href="#"><img src="{{ asset('frontend/assets/images/Menu/facebook-circular-logo 1.svg') }}" alt=""></a>
                <a href="#"><img src="{{ asset('frontend/assets/images/Menu/instagram 1.svg') }}" alt=""></a>
            </div>
            <div class="col-12 text-center">
                <img class="restaLogo" src="{{ asset('images/' . $restaurant->logo) }}" alt="">
            </div>
            <div class="col-12 restaurSubTitle text-center">
                <p> {{ $restaurant->status_id == null ? '' : ($restaurant->status->name == 'CLOSED' ? 'Restaurant is closed now' : 'Delivery available only in Gulshan') }}
                </p>
            </div>
            <div class="col-12 restaurDetails text-center">
                <p>{!! $restaurant->description !!}</p>

                <a id="menu" href="{{ route('frontend.about.us') }}#{{ $restaurant->restaurant_id }}">Read More</a>
            </div>
        </div>
    </section>
    <!-- Menu -->
    {{-- <section class="container-fluid menu-section">
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
                                                        <button
                                                            class="{{ $restaurant->disable == true ? 'addTocart' : 'cartBtn' }}  {{ $restaurant->status->name == 'CLOSED' ? 'd-none' : ' ' }}   menuCartBtn  addTocartBtnId{{ $item->category->restaurant->restaurant_id }}"
                                                            onclick="addToCart({{ $item->item_id }},{{ $item->category->restaurant->restaurant_id }})">Add
                                                            to Cart
                                                        </button>
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
    </section> --}}

    <section class="menu-title-wrapper">
        <div class="container">
            <h1 class="menuTitle">Menu</h1>
        </div>
    </section>

    <section class="menu-navbar-wrapper sticky-top">
        <div class="container">
            <div id="menuNavbar" class="">
                <ul class="scroll-x-navbar nav-pills sideCategories">
                    @if (!empty($restaurant->restaurant_categories))
                        @foreach ($restaurant->restaurant_categories as $category)
                            @if (count($category->available_items) > 0)
                                <li class="nav-item">
                                    <a href="#categories{{ $category->category_id }}"
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
        <div class="container">
            @if (!empty($restaurant->restaurant_categories))
                @foreach ($restaurant->restaurant_categories as $category)
                    <!-- category loop start -->
                    @if (count($category->available_items) > 0)
                        <div class="row categories" id="categories{{ $category->category_id }}">
                            <h1 class="categoriesTitle">{{ $category->name }}</h1>

                            @if (!empty($category->available_items))
                                @foreach ($category->available_items as $item)
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
                                                        <p>{{ $item->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                                <h3 class="price">Tk. {{ currency_format($item->price) }}</h3>

                                                <button
                                                    class="{{ $restaurant->disable == true ? 'addTocart' : 'cartBtn' }}  {{ $restaurant->status->name == 'CLOSED' ? 'd-none' : ' ' }}   menuCartBtn  addTocartBtnId{{ $item->category->restaurant->restaurant_id }}"
                                                    onclick="addToCart({{ $item->item_id }},{{ $item->category->restaurant->restaurant_id }})">Add
                                                    to Cart
                                                </button>
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
    </section>

    @include('layouts.frontend.partials.location_modal')
@endsection
@section('pageScripts')
<script src="{{asset('frontend/assets/js/jquery.mousewheel.min.js')}}"></script>
    <script>
        $('.body').attr('data-bs-spy', 'scroll');
        $('.body').attr('data-bs-target', '#navbarMenu');
        $('.body').attr('data-bs-offset', '200');
        $('.body').attr('tabindex', '0');

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
            $(window).scroll(function() {
                var navbarHeight = $('.navbar').innerHeight();
                $('.menu-navbar-wrapper.sticky-top').css('top', `${parseFloat(navbarHeight -2)}px`)
            })
            $(window).on('wheel', function () {
                $('.categories').removeClass('active');
            });
        })

        $(window).on('activate.bs.scrollspy', function() {
            var $active_nav_item = $("#menuNavbar").find('a.active'),
                $scroll_elem = $(".scroll-x-navbar"),
                left_pos, right_limit, active_elem_left_pos, active_elem_right_pos, scroll_pos, new_scroll_pos;

            if (!$active_nav_item.length) {
                return false;
            }

            left_pos = $scroll_elem.offset().left;
            right_limit = $scroll_elem.width() + left_pos;
            active_elem_left_pos = $active_nav_item.offset().left;
            active_elem_right_pos = $active_nav_item.width() + active_elem_left_pos;
            scroll_pos = $scroll_elem.scrollLeft();

            if (active_elem_left_pos > left_pos && active_elem_right_pos < right_limit) {
                return true;
            } else {
                new_scroll_pos = (left_pos + right_limit) / 2;
                new_scroll_pos = active_elem_left_pos - new_scroll_pos;
                new_scroll_pos = scroll_pos + new_scroll_pos;
                $scroll_elem.scrollLeft(new_scroll_pos);
            }
        })
    </script>
@endsection
