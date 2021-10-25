@include('layouts.frontend.partials.header')
<body>
    <!-- navbar -->
    @include('layouts.frontend.partials.navbar')
    <!-- Cart -->
    @include('layouts.frontend.partials.cart')
    <!-- Content -->
    @yield('content')
    <!-- Footer -->
    @include('layouts.frontend.partials.footer')

    <!-- onload location modal -->
    <!-- <div class="location-modal-box">
        <div class="modal show" tabindex="-1" id="location-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button data-bs-dismiss="modal" class="lmbCloseBtn"><img
                        src="assets/images/My Orders/modal-close.svg" alt=""></button>
                    <div class="modal-body">
                        <div class="image-wrapper">
                            <img src="assets/images/Logos/Emerald Group.svg" alt="logo">
                        </div>
                        <h1>choose your location</h1>
                        <div class="select-box">
                            <select class="" aria-label="Default select example">
                                <option selected>Select Location</option>
                                <option value="1">Gulshan</option>
                                <option value="2">Dhanmondi</option>
                                <option value="3">Banani</option>
                                <option value="4">Uttara</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    
    @include('layouts.frontend.partials.scripts')
    @yield('pageScripts')
</body>
</html>
