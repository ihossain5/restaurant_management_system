    <!-- Jquery CDNJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Bootstrap Js -->
    <script src="{{ asset('frontend/assets/bootstrap-5.1.0/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/bootstrap-5.1.0/bootstrap.min.js') }}"></script>


    <!-- Owl-Carousel -->
    <script src="{{ asset('frontend/assets/OwlCarousel2-2.3.4/owl.carousel.min.js') }}"></script>
    <!-- swipe Js -->
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js'></script>

    <!-- Custom Js -->
    <script src="{{ asset('frontend/assets/js/style.js') }}"></script>
    <script src="{{ asset('backend/assets/js/bd_currency_format.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>


    <script>
        var config = {
            routes: {
                addToCart: "{!! route('frontend.cart.add') !!}",
                updateCart: "{!! route('frontend.cart.update') !!}",
                decreaseCartQty: "{!! route('frontend.cart.decrease.quantity') !!}",
                deleteCart: "{!! route('frontend.cart.delete') !!}",
                changeRestaurant: "{!! route('frontend.cart.change.restaurant') !!}",
                addToCartRestaurant: "{!! route('frontend.cart.add.busy.restaurant') !!}",
            }
        };

        $(document).ajaxStart(function() {
            $('.main_loader').removeClass('d-none');
        });


        $(document).ajaxComplete(function() {
            $('.main_loader').addClass('d-none');
        });

        function locationChange() {
            $('#location-modal').modal('hide');
            $('#locationAlertModal').modal('show');
            var val = $('#select_id').val();
            var url = '{{ route('frontend.restaurant.by.location', ':id') }}';
            url = url.replace(':id', val);
            $('.locationModalhref').attr("href", url);
        }

        function changeLocation() {
            var val = $('#select_id').val();
            var url = '{{ route('frontend.restaurant.by.location', ':id') }}';
            url = url.replace(':id', val);
            window.location.href = url;
        }

        $(document).on('click', '.navbar-modal-show-btn', function() {
            var locationId = $('.locationId').val();
            $('#select_id').val(locationId);
        });


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
            "autohide": false,
            // "showEasing": "swing",
            // "hideEasing": "linear",
            // "showMethod": "fadeIn",
            // "hideMethod": "fadeOut"
        }
        // add to cart
        var locationId = $('.locationId').val();

        function addToCart(item_id, restaurant_id, combo_id) {
            var combo_id = combo_id || '';

            if (combo_id == '') {
                var data = {
                    item_id: item_id,
                    locationId: locationId,
                    restaurant_id: restaurant_id,
                    _token: "{{ csrf_token() }}"
                };
            } else {
                var data = {
                    item_id: item_id,
                    locationId: locationId,
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
                        $('.location-submitBtn').attr('onclick', 'locationChange()');
                        removeTooltip();

                        toastr["success"](response.data.message)
                        $('.cartItem').remove();
                        $('.cartRestaurantName').html(response.data.restaurant_name)
                        $.each(response.data.items, function(key, val) {
                            appendCartItem(val);
                        });
                        appendCartTotal(response.data.subTotal, response.data.vatAmount, response.data
                            .grandTotal, response.data.deliveryCharge)

                        cartCounter(response.data.numberOfCartItems); // set cart counter
                    } else {
                        $('#modal_restaurant_id').val(response.data.restaurant_id);
                        $('#modal_combo_id').val(response.data.combo_id);
                        $('#modal_item_id').val(response.data.item_id);
                        $('#modal_location_id').val(response.data.location_id);
                        $('.alertMessage').html(response.data.message);
                        if (response.data.status == 'BUSY') {
                            $('#alertModalForm').removeClass('cartChangeForm');
                            $('#alertModalForm').addClass('addToCart');
                        } else {
                            $('#alertModalForm').removeClass('addToCart');
                            $('#alertModalForm').addClass('cartChangeForm');
                        }
                        $('#alertModal').modal('show');
                    } //success end
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastr["error"](response.data.message)
                    }
                },
            }); //ajax end
        }

        var delivery_fee = $('.delivery-charge').html();
        // increase cart quantity   
        function increaseQuantity(rowId) {
            var oldQty = $('.cartQty' + rowId).html();

            $.ajax({
                url: config.routes.updateCart,
                method: "POST",
                data: {
                    rowId: rowId,
                    delivery_fee: delivery_fee,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        var newQty = parseInt(oldQty) + 1;
                        // toastr["success"](response.data.message)
                        $('.grandTotal').html(response.data.grandTotal)
                        $('.subTotal').html(response.data.grandTotal)
                        $('.itemTotal' + rowId).html(response.data.price)
                        $('.grandTotal').html(response.data.totalAmount)
                        $('.vat-amount').html(response.data.vatAmount)
                        $('.delivary-charge').html(response.data.deliveryCharge)
                        $('.cartQty' + rowId).html(++oldQty);
                        $('.itmQuantity' + rowId).html(newQty);
                        $('.itemPrice' + rowId).html(response.data.price)
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
        function decreaseQuantity(rowId) {
            var oldQty = $('.cartQty' + rowId).html();
            if (oldQty == 1) {
                toastr["info"]('Quantity can not be less than 1')
            } else {
                $.ajax({
                    url: config.routes.decreaseCartQty,
                    method: "POST",
                    data: {
                        rowId: rowId,
                        delivery_fee: delivery_fee,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success == true) {
                            var newQty = parseInt(oldQty) - 1;
                            $('.cartQty' + rowId).html(--oldQty);
                            $('.itmQuantity' + rowId).html(newQty);
                            $('.subTotal').html(response.data.grandTotal)
                            $('.grandTotal').html(response.data.totalAmount)
                            $('.vat-amount').html(response.data.vatAmount)
                            $('.delivary-charge').html(response.data.deliveryCharge)
                            $('.itemTotal' + rowId).html(response.data.price)
                            $('.itemPrice' + rowId).html(response.data.price)
                            cartCounter(response.data.numberOfCartItems); // set cart counter
                        } //success end
                    },
                    error: function(error) {
                        if (error.status == 404) {
                            toastr["error"]('Data not found');
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
                    delivery_fee: delivery_fee,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        // toastr["success"](response.data.message)
                        $('.subTotal').html(response.data.grandTotal)
                        $('.grandTotal').html(response.data.totalAmount)
                        $('.vat-amount').html(response.data.vatAmount)
                        $('.delivery-charge').html(response.data.deliveryCharge)
                        $('.itemPrice' + rowId).html(response.data.price)
                        $('.cartRow' + rowId).remove();
                        $('.itemRow' + rowId).remove();
                        cartCounter(response.data.numberOfCartItems); // set cart counter
                        if (response.data.numberOfCartItems == 0) {
                            $('.location-submitBtn').attr('onclick', 'changeLocation()');

                            // $('#cartItems').attr('title', 'Cart is empty');
                            // $('#cartItems').attr('data-bs-original-title', 'Cart is empty');
                            $('.cartItems').attr('data-bs-original-title','Cart is empty');
                            $('.cartRestaurantName').empty();
                        }
                    } //success end
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastr["error"]('Data not found');
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
                            window.location.reload();
                            // $('.addTocart').hide();
                            // $('.cartBtn').hide();
                            // $('.card-overlay-box').addClass('disable-overlay');
                            // $.each(response.data.restaurants, function(i, restaurant) {
                            //     console.log(restaurant.restaurant_id);
                            //     $('.restaurantId' + restaurant.restaurant_id).removeClass(
                            //         'disable-overlay');
                            //     $('.addTocartBtnId' + restaurant.restaurant_id).show();
                            //     // $('.addTocartBtnId' + restaurant.restaurant_id).re();
                            //     // $('.comboBtn').after(`<button class="addTocart addTocartBtnId${restaurant.restaurant_id}">Add to Cart</button>`)
                            // });

                            // $('.lmbCloseBtn').show();
                            // $('.headerLocation').html(response.data.location_name);
                            // $('#location-modal').modal('hide');
                        } //success end
                    },
                    error: function(error) {
                        if (error.status == 404) {
                            toastr["error"]('Data not found');
                        }
                    },
                }); //ajax end
            }

        }

        $(document).on('submit', '.cartChangeForm', function(e) {
            e.preventDefault();
            $.ajax({
                url: config.routes.changeRestaurant,
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        removeTooltip();
                        toastr["success"](response.data.message)
                        $('.cartItem').remove();
                        $('.cartRestaurantName').html(response.data.restaurant_name)
                        $('.grandTotal').html(response.data.grandTotal)
                        $.each(response.data.items, function(key, val) {
                            appendCartItem(val);
                        });
                        appendCartTotal(response.data.subTotal, response.data.vatAmount, response.data
                            .grandTotal, response.data.deliveryCharge)
                        cartCounter(response.data.numberOfCartItems); // set cart counter
                        $('#alertModal').modal('hide');
                    } else {
                        toastr["error"]('Data not found');

                    }
                }, //success end
                error: function(error) {
                    if (error.status == 422) {
                        $.each(error.responseJSON.errors, function(i, message) {
                            toastr["error"](message)
                        });

                    }
                },

            });
        });

        // add to cart alert model form
        $(document).on('submit', '.addToCart', function(e) {
            e.preventDefault();
            $.ajax({
                url: config.routes.addToCartRestaurant,
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        toastr["success"](response.data.message)
                        $('.cartItem').remove();
                        $('.grandTotal').html(response.data.grandTotal)
                        $('.cartRestaurantName').html(response.data.restaurant_name)
                        $.each(response.data.items, function(key, val) {
                            appendCartItem(val);
                        });
                        appendCartTotal(response.data.subTotal, response.data.vatAmount, response.data
                            .grandTotal, response.data.deliveryCharge)
                        cartCounter(response.data.numberOfCartItems); // set cart counter
                        $('#alertModal').modal('hide');
                    } else {
                        $('#modal_restaurant_id').val(response.data.restaurant_id);
                        $('#modal_combo_id').val(response.data.combo_id);
                        $('#modal_item_id').val(response.data.item_id);
                        $('.alertMessage').html(response.data.message);
                        if (response.data.status == 'BUSY') {
                            $('#alertModalForm').removeClass('cartChangeForm');
                            $('#alertModalForm').addClass('addToCart');
                        } else {
                            $('#alertModalForm').removeClass('addToCart');
                            $('#alertModalForm').addClass('cartChangeForm');
                        }
                        $('#alertModal').modal('show');

                    }
                }, //success end
                error: function(error) {
                    if (error.status == 422) {
                        $.each(error.responseJSON.errors, function(i, message) {
                            toastr["error"](message)
                        });

                    }
                },

            });
        });

        //remove tooltip
        function removeTooltip() {
            $('.cartItems').removeAttr('title');
            $('.cartItems').removeAttr('data-bs-original-title');
        }

        function cartCounter(number) {
            $('.cartCounter').html(number);
        }

        function appendCartItem(val) {
            $('.cartRestaurantName').after(
                `<div class="cartItem d-flex justify-content-between cartRow${val.rowId}">
                    <div>
                        <p>${val.name}</p>
                        <div class="incrDecBtn">
                            <button onclick="decreaseQuantity('${val.rowId}')"><img src="{{ asset('frontend/assets/images/cart/minus-btn.svg') }}" alt="emerald minus icon"></button>
                            <span class="cartQty${val.rowId}">${val.qty}</span>
                            <button onclick="increaseQuantity('${val.rowId}')" data-id="">
                                <img src="{{ asset('frontend/assets/images/cart/plus-btn.svg') }}" alt="emerald plus icon">
                            </button>
                          </div>
                        </div>
                        <div class="cartRightSide">
                            <button onclick="deleteCart('${val.rowId}')"><img src="{{ asset('frontend/assets/images/cart/delete.svg') }}" alt="emerald deleteIcon"></button>
                                <h6 class="">Tk. <span class="itemTotal${val.rowId}">${bdCurrencyFormat(val.subtotal)}</span></h6>
                        </div>
                </div>`
            )
        }

        // cart subtotal
        function appendCartTotal(subTotal, vatAmount, grandTotal, deliveryCharge) {
            $('.parent-div').empty();
            $('.cartItem:last').after(
                `<div class="parent-div">
                    <div class="calculation d-flex justify-content-between">
                        <div>
                            <h6>Sub Total</h6>
                        </div>
                        <div>
                            <h6>Tk. <span class="subTotal">${subTotal}</span></h6>
                        </div>
                    </div>
                    <div class="calculation d-flex justify-content-between">
                        <div>
                            <h6>VAT</h6>
                        </div>
                        <div>
                            <h6>Tk. <span class="vat-amount">${vatAmount}</span></h6>
                        </div>
                    </div>
                    <div class="calculation d-flex justify-content-between">
                        <div>
                            <h6>Delivery Charge</h6>
                        </div>
                        <div>
                            <h6>Tk. <span class="delivery-charge">${deliveryCharge}</span></h6>
                        </div>
                    </div>
                    <div class="calculation grand-total d-flex justify-content-between py-4">
                        <div>
                            <h6>Grand Total</h6>
                        </div>
                        <div>
                            <h6>Tk. <span class="grandTotal">${grandTotal}</span></h6>
                        </div>
                    </div>
                    <a href="{{ route('frontend.chekout') }}"><button type="button" class="brand-btn rounded-pill">Checkout</button></a>
                    <p class="info-text">One of our representatives will personally call you to confirm your order upon checkout</p>
                </div>
                `);
        }

        <?php if (session()->has('location_id')): ?>
        $('.lmbCloseBtn').show();
        <?php else : ?>
        $('.lmbCloseBtn').hide();
        <?php endif; ?>
    </script>
