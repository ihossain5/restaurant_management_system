    <!-- Jquery CDNJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap Js -->
    <script src="{{asset('frontend/assets/bootstrap-5.1.0/bootstrap.min.js')}}"></script>


    <!-- Owl-Carousel -->
    <script src="{{asset('frontend/assets/OwlCarousel2-2.3.4/owl.carousel.min.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('frontend/assets/js/style.js')}}"></script>



    <script>




        // Deales Carousel
        $(document).ready(function () {
            $(".deals-carousel").owlCarousel({
                responsiveClass: true,
                margin: 15,
                nav: true,
                dotsContainer: '.dots-div',
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        center: true,
                        loop: true,
                        autoWidth: true
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            });

            $(".popular-carousel").owlCarousel({
                responsiveClass: true,
                margin: 15,
                nav: true,
                dotsContainer: '.dots-div2',
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        center: true,
                        loop: true,
                        autoWidth: true
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            });
        });

    </script>