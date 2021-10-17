@extends('layouts.frontend.master')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/home.css') }}">
@endsection

@section('content')
    <!-- Home Page Carousel -->
    <section class="container-fluid p-0">
        <div id="homeCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                @if (!empty($sliders))
                    @foreach ($sliders as $slider)
                        <div class="carousel-item {{ $loop->iteration != 0 ? 'active' : '' }}">
                            <img src="{{ asset('images/' . $slider->pic) }}" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-md-block">
                                <h1>{{ $slider->description }}</h1>
                                <a href="#">Order Now!</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
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
                        <a href="{{ route('restaurant.menu', [$restaurant->restaurant_id]) }}">
                            <div class="card h-100 deliverCard">
                                <div class="card-overlay-box">
                                    <img src="{{ asset('images/' . $restaurant->asset) }}" class="card-img-top" alt="...">
                                    <div class="card-overlay-content">
                                        <img src="{{ 'images/' . $restaurant->logo }}" alt="">
                                        <p>**Delivery available only in Gulshan</p>
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
                    <h2 class="carouselTitle">Deals Only Found Here</h2>
                </div>
                <div class="col-md-6 text-start text-md-end">
                    <div class="dots-div dots">

                    </div>
                </div>
            </div>
        </div>
        <div class="owl-carousel deals-carousel">
            <div>
                <div class="card dealsCard">
                    <div class="overlayDealsBox">
                        <img src="{{ asset('frontend/assets/images/Home/Popular dishes/Rectangle 1.png') }}"
                            class="card-img-top" alt="...">
                        <div class="overlayDealsBtn">
                            View Platter Items
                            <div class="overlayDealsContent">
                                <div class="cardContent">
                                    <h5>The Red Chamber</h5>
                                    <h3>The Red Chamber</h3>
                                    <h5>Chicken Fries</h5>
                                    <h5>Beef Shanks</h5>
                                    <h5>Fried Rice</h5>
                                    <h2>Tk. 1299</h2>
                                    <button>Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <div class="overlayDealsBox">
                        <img src="assets/images/Home/Popular dishes/Rectangle 1.png" class="card-img-top" alt="...">
                        <div class="overlayDealsBtn">
                            View Platter Items

                            <div class="overlayDealsContent">
                                <div class="cardContent">
                                    <h5>The Red Chamber</h5>

                                    <h3>The Red Chamber</h3>

                                    <h5>Chicken Fries</h5>
                                    <h5>Beef Shanks</h5>
                                    <h5>Fried Rice</h5>

                                    <h2>Tk. 1299</h2>

                                    <button>Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <div class="overlayDealsBox">
                        <img src="assets/images/Home/Popular dishes/Rectangle 1.png" class="card-img-top" alt="...">
                        <div class="overlayDealsBtn">
                            View Platter Items

                            <div class="overlayDealsContent">
                                <div class="cardContent">
                                    <h5>The Red Chamber</h5>

                                    <h3>The Red Chamber</h3>

                                    <h5>Chicken Fries</h5>
                                    <h5>Beef Shanks</h5>
                                    <h5>Fried Rice</h5>

                                    <h2>Tk. 1299</h2>

                                    <button>Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <div class="overlayDealsBox">
                        <img src="assets/images/Home/Popular dishes/Rectangle 1.png" class="card-img-top" alt="...">
                        <div class="overlayDealsBtn">
                            View Platter Items

                            <div class="overlayDealsContent">
                                <div class="cardContent">
                                    <h5>The Red Chamber</h5>

                                    <h3>The Red Chamber</h3>

                                    <h5>Chicken Fries</h5>
                                    <h5>Beef Shanks</h5>
                                    <h5>Fried Rice</h5>

                                    <h2>Tk. 1299</h2>

                                    <button>Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <div class="overlayDealsBox">
                        <img src="assets/images/Home/Popular dishes/Rectangle 1.png" class="card-img-top" alt="...">
                        <div class="overlayDealsBtn">
                            View Platter Items

                            <div class="overlayDealsContent">
                                <div class="cardContent">
                                    <h5>The Red Chamber</h5>

                                    <h3>The Red Chamber</h3>

                                    <h5>Chicken Fries</h5>
                                    <h5>Beef Shanks</h5>
                                    <h5>Fried Rice</h5>

                                    <h2>Tk. 1299</h2>

                                    <button>Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <div class="overlayDealsBox">
                        <img src="assets/images/Home/Popular dishes/Rectangle 1.png" class="card-img-top" alt="...">
                        <div class="overlayDealsBtn">
                            View Platter Items

                            <div class="overlayDealsContent">
                                <div class="cardContent">
                                    <h5>The Red Chamber</h5>

                                    <h3>The Red Chamber</h3>

                                    <h5>Chicken Fries</h5>
                                    <h5>Beef Shanks</h5>
                                    <h5>Fried Rice</h5>

                                    <h2>Tk. 1299</h2>

                                    <button>Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <div class="overlayDealsBox">
                        <img src="assets/images/Home/Popular dishes/Rectangle 1.png" class="card-img-top" alt="...">
                        <div class="overlayDealsBtn">
                            View Platter Items

                            <div class="overlayDealsContent">
                                <div class="cardContent">
                                    <h5>The Red Chamber</h5>

                                    <h3>The Red Chamber</h3>

                                    <h5>Chicken Fries</h5>
                                    <h5>Beef Shanks</h5>
                                    <h5>Fried Rice</h5>

                                    <h2>Tk. 1299</h2>

                                    <button>Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <div class="overlayDealsBox">
                        <img src="assets/images/Home/Popular dishes/Rectangle 1.png" class="card-img-top" alt="...">
                        <div class="overlayDealsBtn">
                            View Platter Items

                            <div class="overlayDealsContent">
                                <div class="cardContent">
                                    <h5>The Red Chamber</h5>

                                    <h3>The Red Chamber</h3>

                                    <h5>Chicken Fries</h5>
                                    <h5>Beef Shanks</h5>
                                    <h5>Fried Rice</h5>

                                    <h2>Tk. 1299</h2>

                                    <button>Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>
            <div>
                <div class="card dealsCard">
                    <div class="overlayDealsBox">
                        <img src="assets/images/Home/Popular dishes/Rectangle 1.png" class="card-img-top" alt="...">
                        <div class="overlayDealsBtn">
                            View Platter Items
                            <div class="overlayDealsContent">
                                <div class="cardContent">
                                    <h5>The Red Chamber</h5>
                                    <h3>The Red Chamber</h3>
                                    <h5>Chicken Fries</h5>
                                    <h5>Beef Shanks</h5>
                                    <h5>Fried Rice</h5>

                                    <h2>Tk. 1299</h2>

                                    <button>Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Popular Dishes -->
    <section class="container-fluid popular-dishes">
        <div class="popular-section-header">
            <div class="row pb-5">
                <div class="col-md-6">
                    <h2 class="carouselTitle">Popular Dishes</h2>
                </div>
                <div class="col-md-6 text-start text-md-end">
                    <div class="dots-div2 dots">

                    </div>
                </div>
            </div>
        </div>
        <div class="owl-carousel popular-carousel">
            <div>
                <div class="card dealsCard">
                    <img src="{{ asset('frontend/assets/images/Home/Popular dishes/Rectangle 1.png') }}"
                        class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <img src="{{ asset('frontend/assets/images/Home/Popular dishes/Rectangle 1-1.png') }}"
                        class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Classic</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <img src="{{ asset('frontend/assets/images/Home/Popular dishes/Rectangle 1-2.png') }}"
                        class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6>Gusto</h6>
                        <h3>Fried Fiesta</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <img src="{{ asset('frontend/assets/images/Home/Popular dishes/Rectangle 1-3.png') }}"
                        class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>
            <div>
                <div class="card dealsCard">
                    <img src="{{ asset('frontend/assets/images/Home/Popular dishes/Rectangle 1.png') }}"
                        class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <img src="assets/images/Home/Popular dishes/Rectangle 1-1.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Classic</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <img src="assets/images/Home/Popular dishes/Rectangle 1-2.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6>Gusto</h6>
                        <h3>Fried Fiesta</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>

            <div>
                <div class="card dealsCard">
                    <img src="assets/images/Home/Popular dishes/Rectangle 1-3.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h6>The Red Chamber</h6>
                        <h3>The Signature Rou</h3>
                        <h2>Tk. 1299</h2>
                        <button>Add to Cart</button>
                    </div>
                </div>
            </div>


        </div>
    </section>
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
    </script>
@endsection
