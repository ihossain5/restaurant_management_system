@extends('layouts.frontend.master')
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
                <div class="carousel-item active">
                    <img src="{{ asset('frontend/assets/images/Menu/Rectangle 6.png') }}" class=" d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('frontend/assets/images/Menu/Rectangle 6.png') }}" class=" d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('frontend/assets/images/Menu/Rectangle 6.png') }}" class=" d-block w-100" alt="...">
                </div>
            </div>
        </div>
    </section>


    <!-- Restaurent Details -->
    <section class="container-fluid restaurent-Details">
        <div class="row">
            <div class="col-12 text-center social-link">
                <a href="#"><img src="assets/images/Menu/facebook-circular-logo 1.svg" alt=""></a>
                <a href="#"><img src="assets/images/Menu/instagram 1.svg" alt=""></a>
            </div>
            <div class="col-12 text-center">
                <img class="restaLogo" src="assets/images/About Us/Logos/Trouvaille.svg" alt="">
            </div>
            <div class="col-12 restaurSubTitle text-center">
                <p> Delivery available only in Gulshan</p>
            </div>
            <div class="col-12 restaurDetails text-center">
                <p>Remember all the times we spared no effort in searching for something and we only found it when we
                    stopped looking? Well, that’s the beauty of life. We chance upon certain things when we least expect
                    them. It’s like walking towards the unknown only to find surprises. There’s an underlying
                    satisfaction to it, it keeps us humble</p>

                <a href="about-us.html#trouvaille">Read More</a>
            </div>
        </div>
    </section>


    <!-- Menu -->
    <section class="container-fluid menu-section">
        <div class="row">
            <div class="col-12">
                <h1 class="menuTitle">Menu</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 d-none d-lg-block">
                <div class="sideCatSticky ">
                    <ul class="sideCategories">
                        <li><a href="#categories1">Soup (4)</a></li>
                        <li><a href="#categories2">Starter (6)</a></li>
                        <li><a href="#categories3">dumplings (5)</a></li>
                        <li><a href="#categories4">meat & poultry (8)</a></li>
                        <li><a href="#categories5">seafood (6)</a></li>
                        <li><a href="#categories6">vegetable (4)</a></li>
                        <li><a href="#categories7">rice & noodles (5)</a></li>
                        <li><a href="#categories8 ">add-ons (5)</a></li>
                        <li><a href="#categories9">drinks (7)</a></li>
                        <li><a href="#categories10">dessert (7)</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="menu-container">
                    <div class="row">
                        <div class="col-12 categories" id="categories1">
                            <h1 class="categoriesTitle">Soup</h1>
                        </div>
                    </div>

                    <div class="row">
                        <!-- item -->
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 pt-5 categories" id="categories2">
                            <h1 class="categoriesTitle">Starter</h1>
                        </div>
                    </div>

                    <div class="row">
                        <!-- item -->
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 pt-5 categories" id="categories3">
                            <h1 class="categoriesTitle">dumplings (5)</h1>
                        </div>
                    </div>

                    <div class="row">
                        <!-- item -->
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 pt-5 categories" id="categories4">
                            <h1 class="categoriesTitle">meat & poultry (8)</h1>
                        </div>
                    </div>

                    <div class="row">
                        <!-- item -->
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 pt-5 categories" id="categories5">
                            <h1 class="categoriesTitle">seafood (6)</h1>
                        </div>
                    </div>

                    <div class="row">
                        <!-- item -->
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 pt-5 categories" id="categories6">
                            <h1 class="categoriesTitle">vegetable (4)</h1>
                        </div>
                    </div>

                    <div class="row">
                        <!-- item -->
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 pt-5 categories" id="categories7">
                            <h1 class="categoriesTitle">rice & noodles (5)</h1>
                        </div>
                    </div>

                    <div class="row">
                        <!-- item -->
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 pt-5 categories" id="categories8">
                            <h1 class="categoriesTitle">add-ons (5)</h1>
                        </div>
                    </div>

                    <div class="row">
                        <!-- item -->
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 pt-5 categories" id="categories9">
                            <h1 class="categoriesTitle">drinks (7)</h1>
                        </div>
                    </div>

                    <div class="row">
                        <!-- item -->
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 pt-5 categories" id="categories10">
                            <h1 class="categoriesTitle">dessert (7)</h1>
                        </div>
                    </div>

                    <div class="row">
                        <!-- item -->
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-12 item mb-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="w-100" src="assets/images/Menu/Rectangle 7-1.png" alt="">
                                        </div>
                                        <div class="col-md-8 item-content pt-5 pt-md-0">
                                            <h3>Cream of Mushroom</h3>
                                            <ul>
                                                <li>Sweet</li>
                                                <li>For 1 Person</li>
                                            </ul>
                                            <p>A classic smooth & creamy soup
                                                with intense earthy flavours.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-5 pt-md-0 text-start text-md-end">
                                    <h3 class="price">Tk. 1200</h3>
                                    <button class="cartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
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
