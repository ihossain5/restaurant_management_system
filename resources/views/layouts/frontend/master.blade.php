@include('layouts.frontend.partials.header')

<body class="body">
    <!-- navbar -->
    @include('layouts.frontend.partials.navbar')
    <!-- Cart -->
    @include('layouts.frontend.partials.cart')

    <!-- Content -->
    @yield('content')
    <div class="loadingio-spinner-eclipse-rj8h1fnvngt main_loader d-none">
        <div class="ldio-upmsczc93rp">
            <div></div>
        </div>
    </div>
    <!-- Footer -->
    @include('layouts.frontend.partials.footer')
    
    @include('layouts.frontend.partials.modals.cartAlert-modal')

    @include('layouts.frontend.partials.scripts')
    @yield('pageScripts')
</body>

</html>
