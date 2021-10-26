    <!-- Jquery CDNJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap Js -->
    <script src="{{ asset('frontend/assets/bootstrap-5.1.0/bootstrap.min.js') }}"></script>


    <!-- Owl-Carousel -->
    <script src="{{ asset('frontend/assets/OwlCarousel2-2.3.4/owl.carousel.min.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('frontend/assets/js/style.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

    <script>
        var config = {
            routes: {
                addToCart: "{!! route('frontend.cart.add') !!}",
                updateCart: "{!! route('frontend.cart.update') !!}",
                decreaseCartQty: "{!! route('frontend.cart.decrease.quantity') !!}",
                deleteCart: "{!! route('frontend.cart.delete') !!}",
                getRestaurants: "{!! route('frontend.restaurant.by.location') !!}",
            }
        };


        // Deales Carousel
        $(document).ready(function() {
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
            if ($('.dealsDot button').length > 1) {
                $('.dealsDot').removeClass('d-none');
            }
            if ($('.popularDot button').length > 1) {
                $('.popularDot').removeClass('d-none');
            }


        });

        //toaster
        toastr.options = {
            "closeButton": true,
            "debug": true,
            "tapToDismiss ": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        // add to cart
        function addToCart(item_id, restaurant_id, combo_id) {
            var combo_id = combo_id || '';
            if (combo_id == '') {
                var data = {
                    item_id: item_id,
                    restaurant_id: restaurant_id,
                    _token: "{{ csrf_token() }}"
                };
            } else {
                var data = {
                    item_id: item_id,
                    restaurant_id: restaurant_id,
                    combo_id: combo_id,
                    _token: "{{ csrf_token() }}"
                }
            }
            $.ajax({
                url: config.routes.addToCart,
                method: "POST",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        toastr["success"](response.data.message)
                        $('.cartItem').remove();
                        $('.grandTotal').html(response.data.grandTotal)
                        $.each(response.data.items, function(key, val) {
                            $('#cartName').after(
                                `<div class="cartItem d-flex justify-content-between cartRow${val.rowId}">
                                    <div>
                                        <p>${val.name}</p>
                                        <div class="incrDecBtn">
                                            <button onclick="minusBtn('${val.rowId}')"><img src="{{ asset('frontend/assets/images/cart/minus-btn.svg') }}" alt="emerald minus icon"></button>
                                        
                                            <span class="cartQty${val.rowId}">${val.qty}</span>
                                            
                                            <button onclick="plusBtn('${val.rowId}')" data-id="">
                                                <img src="{{ asset('frontend/assets/images/cart/plus-btn.svg') }}" alt="emerald plus icon">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cartRightSide">
                                        <button onclick="deleteCart('${val.rowId}')"><img src="{{ asset('frontend/assets/images/cart/delete.svg') }}" alt="emerald deleteIcon"></button>
                                        <h6 class="">Tk. <span class="itemTotal${val.rowId}">${val.subtotal}</span></h6>
                                    </div>
                                </div>`
                            )
                        });
                        $('.parent-div').empty();
                        $('.cartItem:last').after(
                            `<div class="parent-div"> 
                                <div class="calculation d-flex justify-content-between">
                                    <div>
                                        <h6>Sub Total</h6>
                                    </div>
                                    <div>
                                        <h6>Tk. <span class="subTotal">${response.data.subTotal}</span></h6>
                                    </div>
                                </div>
                                <div class="calculation d-flex justify-content-between">
                                    <div>
                                        <h6>VAT</h6>
                                    </div>
                                    <div>
                                        <h6>Tk. 85</h6>
                                    </div>
                                </div>
                                <div class="calculation grand-total d-flex justify-content-between py-4">
                                    <div>
                                        <h6>Grand Total</h6>
                                    </div>
                                    <div>
                                        <h6>Tk. <span class="grandTotal">${response.data.subTotal}</span></h6>
                                    </div>
                                </div>
                                <a href="{{ route("frontend.chekout") }}"><button type="button" class="brand-btn rounded-pill">Checkout</button></a>
                                <p class="info-text">One of our representatives will personally call you to confirm your order upon checkout</p>
                           </div>`);
                           cartCounter(response.data.numberOfCartItems); // set cart counter
                    } else {
                        toastr["error"](response.message)
                    } //success end
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastr["error"](response.data.message)
                    }
                },
            }); //ajax end
        }

        // increase cart quantity   
        function plusBtn(rowId) {
            // alert('sdsd');
            var oldQty = $('.cartQty' + rowId).html();
            $.ajax({
                url: config.routes.updateCart,
                method: "POST",
                data: {
                    rowId: rowId,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        // toastr["success"](response.data.message)
                        $('.grandTotal').html(response.data.grandTotal)
                        $('.subTotal').html(response.data.grandTotal)
                        $('.itemTotal' + rowId).html(response.data.price)
                        $('.cartQty' + rowId).html(++oldQty);
                        cartCounter(response.data.numberOfCartItems); // set cart counter
                    } //success end
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastr["error"](response.data.message)
                    }
                },
            }); //ajax end
        }

        // decrease cart quantity   
        function minusBtn(rowId) {
            var oldQty = $('.cartQty' + rowId).html();

            if (oldQty == 1) {
                toastr["info"]('Quantity can not be less than 1')
            } else {
                $.ajax({
                    url: config.routes.decreaseCartQty,
                    method: "POST",
                    data: {
                        rowId: rowId,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success == true) {
                            $('.cartQty' + rowId).html(--oldQty);
                            $('.subTotal').html(response.data.grandTotal)
                            $('.grandTotal').html(response.data.grandTotal)
                            $('.itemTotal' + rowId).html(response.data.price)
                            cartCounter(response.data.numberOfCartItems); // set cart counter
                        } //success end
                    },
                    error: function(error) {
                        if (error.status == 404) {
                            toastMixin.fire({
                                icon: 'error',
                                animation: true,
                                title: "" + 'Data not found' + ""
                            });
                        }
                    },
                }); //ajax end
            }

        }

        function deleteCart(rowId) {
            $.ajax({
                url: config.routes.deleteCart,
                method: "POST",
                data: {
                    rowId: rowId,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        // toastr["success"](response.data.message)
                        $('.grandTotal').html(response.data.grandTotal)
                        $('.subTotal').html(response.data.grandTotal)
                        $('.cartRow' + rowId).remove();
                        cartCounter(response.data.numberOfCartItems); // set cart counter
                    } //success end
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastMixin.fire({
                            icon: 'error',
                            animation: true,
                            title: "" + 'Data not found' + ""
                        });
                    }
                },
            }); //ajax end
        }

        // location change function
        function getRestaurants() {
            id = document.getElementById("select_id").value;
            if (id == '') {
                $('.lmbCloseBtn').hide();
            } else {
                $.ajax({
                    url: config.routes.getRestaurants,
                    method: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success == true) {
                            $('.addTocart').hide();
                            $('.cartBtn').hide();
                            $('.card-overlay-box').addClass('disable-overlay');
                            $.each(response.data.restaurants, function(i, restaurant) {
                                console.log(restaurant.restaurant_id);
                                $('.restaurantId' + restaurant.restaurant_id).removeClass(
                                    'disable-overlay');
                                $('.addTocartBtnId' + restaurant.restaurant_id).show();
                                // $('.comboBtn').after(`<button class="addTocart addTocartBtnId${restaurant.restaurant_id}">Add to Cart</button>`)
                            });

                            $('.lmbCloseBtn').show();
                            $('.headerLocation').html(response.data.location_name);
                            $('#location-modal').modal('hide');
                        } //success end
                    },
                    error: function(error) {
                        if (error.status == 404) {
                            toastMixin.fire({
                                icon: 'error',
                                animation: true,
                                title: "" + 'Data not found' + ""
                            });
                        }
                    },
                }); //ajax end
            }

        }

      function cartCounter(number){
          $('.cartCounter').html(number);

      }  
    </script>
