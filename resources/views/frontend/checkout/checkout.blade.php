@extends('layouts.frontend.master')
@section('title')
    Checkout
@endsection
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/checkout.css') }}">
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
                                </div>
                                <div class="col-12 pb-3">
                                    <h5>Mobile Number</h5>
                                    <p class="contact">{{ $customer->contact ?? 'N/A' }}</p>
                                </div>

                            </div>
                        </div>
                        <div class="deliveryInfoInput d-none">
                            <form id="addressForm">
                                <div class="row formInput profile-input pt-5">
                                    <div class="col-12">
                                        <input class="form-control" name="address" type="text" id="address" placeholder="Address"
                                            value="{{ $customer->address }}">

                                    </div>
                                    <div class="col-12">
                                        <input class="form-control" type="text" name="contact" id="contact" placeholder="Mobile Number"
                                            value="{{ $customer->contact }}">
                                    </div>

                                    <div class="col-12 mt-5">
                                        <div class="form-check custom-check">
                                            <input class="form-check-input" name="setDefaultAddress" type="checkbox" checked id="newAddres1">
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
                                <button type="submit" class="editBtnAcountInfo editBtn"><img
                                        src="{{ asset('frontend/assets/images/Checkout/edit.svg') }}" alt=""></button>
                            </div>
                        </div>
                        <div class="acountInfo">
                            <div class="row profile p-0">
                                <div class="col-12 pb-3">
                                    <h5>Name</h5>
                                    <p>{{ $customer->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-12 pb-3">
                                    <h5>Email</h5>
                                    <p>{{ $customer->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        {{-- <form action=""></form> --}}
                        <div class="acountInfoInput d-none">
                            <div class="row formInput profile-input pt-5">
                                <div class="col-12">
                                    <input class="form-control" name="name" id="name" type="text" placeholder="Your Name"
                                        value="{{ $customer->name }}">

                                </div>
                                <div class="col-12">
                                    <input class="form-control" name="email" id="email" type="text" placeholder="Your Email"
                                        value="{{ $customer->email }}">
                                </div>
                                <div class="col-12 mt-5">
                                    <div class="form-check custom-check">
                                        <input class="form-check-input" type="checkbox" id="newAddress">
                                        <label class="form-check-label" for="newAddress">
                                            Save this as my delivery address for future
                                            reference
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <button class="rounded-pill acountInfoBtn">Save Changes</button>
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
                            <input type="hidden" name="restaurant_id" value="{{$restaurant->restaurant_id}}">
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
                                            Tk. 85
                                        </div>
                                    </li>
                                    <li>
                                        <div class="firstColumn">
                                            Delivery Fee
                                        </div>
                                        <div class="secondColumn">
                                            Tk. 60
                                        </div>
                                    </li>
                                    <li>
                                        <div class="firstColumn">
                                            Grand Total
                                        </div>
                                        <div class="secondColumn">
                                            Tk. {{ Cart::subtotal() }}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control specInstruction" name="instruction" cols="30" rows="6"
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
    {{-- @include('layouts.frontend.partials.location_modal') --}}
@endsection
@section('pageScripts')
    <script>
        var config = {
            routes: {
                placeOrder: "{!! route('order.place') !!}",
            }
        };
        $(document).on('submit', '#placeOrder', function(e) {
            e.preventDefault();
            $.ajax({
                url: config.routes.placeOrder,
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {

                    } else {

                    }
                }, //success end

            });
        });

        function save() {
            var checkbox = document.getElementById("newAddres1");
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


        // $("#placeOrder").validate({
        //         rules: {
        //             name: {
        //                 required: true,
        //                 maxlength: 50,
        //             },
        //             email: {
        //                 required: true,
        //                 email: true,
        //             },
        //             contact: {
        //                 required: true,
        //             },
        //         },
        //         messages: {
        //             name: {
        //                 required: 'Please insert employee name',
        //             },
        //             email: {
        //                 required: 'Please insert employee email',
        //             },
        //         },
        //         errorPlacement: function(label, element) {
        //             label.addClass('mt-2 text-danger');
        //             label.insertAfter(element);
        //         },
        //     }); 
    </script>
@endsection