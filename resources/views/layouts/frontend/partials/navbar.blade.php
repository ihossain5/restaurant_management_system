    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-custom sticky-top">    
        <div class="container-fluid nav-container">
            <div class="navbar-brand-wrapper">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                    aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <div class="bar-wrapper">
                        <div class="line line-one"></div>
                        <div class="line line-two"></div>
                        <div class="line line-three"></div>
                    </div>
                </button>
                <a class="navbar-brand d-block" href="{{route('frontend.index')}}"><img src="{{asset('frontend/assets/images/Logos/logo-new.png')}}" alt="Emerald Logo"></a>
            </div>
            <div class="navbar-cart d-lg-none">
                <div onclick="cartToggle()" class="" style="cursor: pointer;" aria-current="page">
                    <img src="{{asset('frontend/assets/images/Home/cart.svg')}}" alt="emerald cart">
                </div>
            </div>
            <div class="navbar-location-select-box d-none d-lg-block">
                <button type="button" class="navbar-modal-show-btn" data-bs-toggle="modal" data-bs-target="#location-modal">
                    Gulshan
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <div class="navbar-large-device d-none d-lg-block">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('frontend.about.us')}}">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('frontend.customer.sign.in')}}">sign in</a>
                        </li>
    
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                My Profile
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="profile.html">My Profile</a></li>
                                <li><a class="dropdown-item" href="allOrder.html">My Orders</a></li>
                                <li><a class="dropdown-item" href="/">sign out</a></li>
                            </ul>
                        </li> -->
    
                        <li class="nav-item">
                            <div onclick="cartToggle()" class="nav-link active" style="cursor: pointer;"
                                aria-current="page"><img src="{{asset('frontend/assets/images/Home/cart.svg')}}" alt="emerald cart"></div>
                        </li>
                    </ul>
                </div>
                
                <ul class="navbar-nav navbar-small-device d-lg-none">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('frontend.about.us')}}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="profile.html">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="allOrder.html">My Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/">sign out</a>
                    </li>
                </ul>
                <div class="navbar-location-select-box d-lg-none">
                    <button type="button" class="navbar-modal-show-btn" data-bs-toggle="modal" data-bs-target="#location-modal">
                        Gulshan
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="nav-overlay"></div>