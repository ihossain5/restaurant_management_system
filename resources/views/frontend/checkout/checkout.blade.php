@extends('layouts.frontend.master')
@section('title')
    Checkout
@endsection
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
@endsection
@section('content')
    <!-- Header Images -->
    <section class="page-banner">
        <img class="w-100" src="{{ asset('frontend/assets/images/Checkout/image 16.png') }}" alt="">
    </section>
    <!-- Checkout Section -->
    <section class="checkout">
        <form id="placeOrder" method="POST"> @csrf
            <div class="row">
                <div class="col-lg-7 col-xl-7 right-border order-1 order-lg-0">
                    <div class="info-box info-box1">
                        <div class="row">
                            <div class="col-10">
                                <h1>Delivery address</h1>
                                <span>**Delivery available only inside Dhaka</span>
                            </div>
                            <div class="col-2 text-end">
                                <button type="button" class="editBtnDeliveryInfo editBtn"><img
                                        src="{{ asset('frontend/assets/images/Checkout/edit.svg') }}" alt=""></button>
                            </div>
                        </div>
                        <div class="deliveryInfo">
                            <div class="row profile p-0">
                                <div class="col-12 pb-3">
                                    <h5>Address</h5>
                                    <p class="address">{{ $customer->address ?? 'N/A' }}</p>
                                    <input type="hidden" class="contactAddress">
                                </div>
                                <div class="col-12 pb-3">
                                    <h5>Mobile Number</h5>
                                    <p class="contact">{{ $customer->contact ?? 'N/A' }}</p>
                                    <input type="hidden" class="contactNumber">
                                    {{-- <label id="-error" class="error mt-2 text-danger h3" for=""></label> --}}
                                </div>

                            </div>
                        </div>
                        <div class="deliveryInfoInput d-none">
                            <form id="addressForm">
                                <div class="row formInput profile-input pt-5">
                                    <div class="col-12">
                                        <input class="form-control" name="address" type="text" id="address"
                                            placeholder="Address" value="{{ $customer->address }}">

                                    </div>
                                    <div class="col-12">
                                        <input class="form-control" type="text" name="contact" id="contact"
                                            placeholder="Mobile Number" value="{{ $customer->contact }}">
                                    </div>

                                    <div class="col-12 mt-5">
                                        <div class="form-check custom-check">
                                            <input class="form-check-input" name="setDefaultAddress" type="checkbox"
                                                id="newAddres1">
                                            <label class="form-check-label" for="newAddress1">
                                                Save this as my delivery address for future
                                                reference
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="button" onclick="save()" class="rounded-pill deliveryInfoBtn">Save
                                            Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="info-box info-box2">
                        <div class="row">
                            <div class="col-10">
                                <h1>account information</h1>
                            </div>
                            <div class="col-2 text-end">
                                <button type="button" class="editBtnAcountInfo editBtn"><img
                                        src="{{ asset('frontend/assets/images/Checkout/edit.svg') }}" alt=""></button>
                            </div>
                        </div>
                        <div class="acountInfo">
                            <div class="row profile p-0">
                                <div class="col-12 pb-3">
                                    <h5>Name</h5>
                                    <p class="name">{{ $customer->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-12 pb-3">
                                    <h5>Email</h5>
                                    <p class="email">{{ $customer->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="acountInfoInput d-none">
                            <div class="row formInput profile-input pt-5">
                                <div class="col-12">
                                    <input class="form-control" name="name" id="name" type="text" placeholder="Your Name"
                                        value="{{ $customer->name }}">

                                </div>
                                <div class="col-12">
                                    <input class="form-control" name="email" id="email" type="text"
                                        placeholder="Your Email" value="{{ $customer->email }}">
                                </div>
                                <div class="col-12 mt-5">
                                    <div class="form-check custom-check">
                                        <input class="form-check-input" name="setDefaultInfo" type="checkbox"
                                            id="newAddress">
                                        <label class="form-check-label" for="newAddress">
                                            Save this as my delivery address for future
                                            reference
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" onclick="saveCustomerInfo()"
                                        class="rounded-pill acountInfoBtn">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="paymentOption">
                        <div class="row">
                            <div class="col-12">
                                <h1>Payment Options</h1>
                                <p>Dear patrons, please be informed at the moment we only accept <b>Cash on delivery.</b>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row posmd d-lg-none">
                        <div class="col-12 mt-3 mb-3">
                            <a href="orderPlaced.html"><button class="brand-btn rounded-pill">Place Order</button></a>
                        </div>
                        <div class="col-12">
                            <p class="checkoutNote">One of our representatives will personally call you to confirm your
                                order upon checkout</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-5 order-0 order-lg-1">
                    <div class="rigthCart">
                        <div class="row align-items-center pb-5">
                            <div class="col-6 col-md-6">
                                <h1 class="checkoutCart-title">My Cart</h1>
                            </div>
                            <input type="hidden" name="restaurant_id" value="{{ $restaurant->restaurant_id }}">
                            <div class="col-6 col-md-6 text-end">
                                <img style="max-width: 16.5rem;" src="{{ asset('images/' . $restaurant->logo) }}" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <ul class="checkoutCartItem">
                                    <!-- Cart Item -->
                                    @foreach (Cart::content() as $cart)
                                        {{-- <input type="hidden" name="cartId" value="{{$cart->rowId}}"> --}}
                                        <li>
                                            <div>
                                                <span class="itmQuantity">{{ $cart->qty }}X</span>
                                            </div>
                                            <div>
                                                <span class="itemName">{{ $cart->name }}</span>
                                            </div>
                                            <div>
                                                <span class="itemPrice">Tk.
                                                    {{ currency_format($cart->subtotal) }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                    <!-- Cart Item -->
                                </ul>
                            </div>
                            <div class="col-12">
                                <ul class="allItemPriceBox">
                                    <li>
                                        <div class="firstColumn">
                                            Sub Total
                                        </div>
                                        <div class="secondColumn">
                                            Tk. {{ Cart::subtotal() }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="firstColumn">
                                            VAT
                                        </div>
                                        <div class="secondColumn">
                                            Tk. {{ $vatAMount }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="firstColumn">
                                            Delivery Fee
                                        </div>
                                        <div class="secondColumn">
                                            Tk. {{ $deliveryCharge }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="firstColumn">
                                            Grand Total
                                        </div>
                                        <div class="secondColumn">
                                            Tk. {{ $totalAmount }}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control specInstruction" name="instruction" cols="30" rows="3"
                                    placeholder="Special Instructions"></textarea>
                            </div>

                            <div class="col-12 mt-3 mb-3 d-none d-lg-block">
                                <a href="orderPlaced.html"><button class="brand-btn rounded-pill">Place Order</button></a>
                            </div>
                            <div class="col-12 d-none d-lg-block">
                                <p class="checkoutNote">One of our representatives will personally call you to confirm
                                    your
                                    order upon checkout</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    @include('layouts.frontend.partials.location_modal')
@endsection
@section('pageScripts')
    <script>
        var locationModal = new bootstrap.Modal(document.getElementById('location-modal'), {
            keyboard: false
        })
        var config = {
            routes: {
                placeOrder: "{!! route('order.place') !!}",
            }
        };
        $('.contactNumber').hide();

        function save() {
            var address = document.getElementById('address').value;
            var contact = document.getElementById('contact').value;
            if (address == '') {
                $('.error_msg').remove();
                $('#address').after(`<label class="h3 text-danger error_msg" for="">Please insert address</label>`)
            } else if (contact == '') {
                $('.error_msg').remove();
                $('#contact').after(`<label class="h3 text-danger error_msg" for="">Please insert mobile number</label>`)
            } else {
                $('.error_msg').hide();
                $('.deliveryInfoInput').addClass('d-none');
                $('.deliveryInfo').removeClass('d-none');
                $('.editBtnDeliveryInfo').removeClass('d-none');

                $('.info-box1').css({
                    "background": "#FFFFFF",
                    "border": "1px solid #F2F2F2",
                    "box-shadow": "4px 12px 60px rgba(0, 0, 0, 0.03)",
                    "padding": "5.6rem",
                });
                $('.address').html(address);
                $('.contact').html(contact);
            }

            // if (checkbox.checked) {
            //     alert("checked");
            // } else {
            //     var address = document.getElementById('address').value;
            //     $('.address').html(address);
            //     var contact = document.getElementById('contact').value;
            //     $('.contact').html(contact);
            // }
        }

        function saveCustomerInfo() {
            var checkbox = document.getElementById("newAddres1");
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            if (name == '') {
                $('.error_msg').remove();
                $('#name').after(`<label class="h3 text-danger error_msg" for="">Please insert your name</label>`)
            } else if (email == '') {
                $('.error_msg').remove();
                $('#email').after(`<label class="h3 text-danger error_msg" for="">Please insert your email</label>`)
            } else {

            $('.acountInfoInput').addClass('d-none');
            $('.acountInfo').removeClass('d-none');
            $('.editBtnAcountInfo').removeClass('d-none');

            $('.info-box2').css({
                "background": "#FFFFFF",
                "border": "1px solid #F2F2F2",
                "box-shadow": "4px 12px 60px rgba(0, 0, 0, 0.03)",
                "padding": "5.6rem",
            });
          }
        }

        // jQuery.validator.addClassRules('contactNumber', {
        //     required: true /*,
        //     other rules */
        // });

        // jQuery.validator.addClassRules('contactAddress', {
        //     required: true /*,
        //     other rules */
        // });

        //     $.validator.addClassRules({
        //     contactAddress: {
        //         required: true,
        //         number: true
        //     },
        //     contactNumber: {
        //         required: true,
        //         email: true
        //     }
        // });

        // $("#placeOrder").validate({
        //     ignore: [],
        //     errorPlacement: function(label, element) {
        //         label.addClass('mt-2 text-danger');
        //         label.insertAfter(element);
        //     },
        // });

        $("#placeOrder").validate({
                rules: {
                    instruction: {
                        maxlength: 100,
                    },
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger h3');
                    label.insertAfter(element);
                },
            });

        $(document).on('submit', '#placeOrder', function(e) {
            e.preventDefault();
            var address = $('.address').html();
            var contact = $('.contact').html();
            var name = $('.name').html();
            var email = $('.email').html();
            if (address == 'N/A' || address == '') {
                $('#address-error').remove();
                $('#contact-error').remove();
                $('#name-error').remove();
                $('#email-error').remove();
                $('.address').after(
                    `<label id="address-error" class="error mt-2 text-danger h3" for="">Please insert your address</label>`
                );
            } else if (contact == 'N/A' || contact == '') {
                $('.contact').after(
                    `<label id="contact-error" class="error mt-2 text-danger h3" for="">Please insert your mobile number</label>`
                );
            } else if (name == 'N/A' || name == '') {
                $('.name').after(
                    `<label id="name-error" class="error mt-2 text-danger h3" for="">Please insert your name</label>`
                );
            } else if (email == 'N/A' || email == '') {
                $('.email').after(
                    `<label id="email-error" class="error mt-2 text-danger h3" for="">Please insert your email</label>`
                );
            } else {
                $.ajax({
                    url: config.routes.placeOrder,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {
                        if (response.success == true) {
                            var url = '{{ route('order.placed', ':id') }}';
                            url = url.replace(':id', response.data.order_id);
                            window.location.replace(url);
                        } else {
                            toastr["error"](response.message)
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
            }

        });
    </script>
@endsection
