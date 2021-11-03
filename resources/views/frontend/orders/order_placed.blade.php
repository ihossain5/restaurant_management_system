@extends('layouts.frontend.master')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
@endsection
@section('title')
    Order Placed
@endsection

@section('content')
    <!-- Header Images -->
    <section class="page-banner">
        <img class="w-100" src="{{asset('frontend/assets/images/Checkout/image 16.png')}}" alt="">
    </section>


    <!-- Checkout Section -->
    <section class="checkout">
        <div class="row">
            <div class="col-lg-8">
                <div class="orderPlaced">
                    <div class="row">
                        <div class="col-12">
                            <h1>order placed!</h1>
                            <h6>Thank you for ordering from Emerald Restaurants! </h6>

                            <p>Upon receiving your order, one of our representatives will personally <b>call you at
                                    {{$contact}}</b> to confirm your order.</p>
                            <a href="{{route('frontend.customer.order')}}">View My Orders</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="rigthCart">
                    <div class="row align-items-center pb-5">
                        <div class="col-6 col-md-6">
                            <h1 class="checkoutCart-title">My Order</h1>
                        </div>
                        <div class="col-6 col-md-6 text-end">
                            <img style="max-width: 16.5rem;" src="{{asset('images/'.$order->restaurant->logo)}}" alt="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <ul class="checkoutCartItem">
                                <!-- Cart Item -->
                                @foreach ($orderItems as $item)
                                <li>
                                    <div>
                                        <span class="itmQuantity">{{$item->pivot->quantity}}X</span>
                                    </div>
                                    <div>
                                        <span class="itemName">{{$item->name}}</span>
                                    </div>
                                    <div>
                                        <span class="itemPrice">Tk. {{currency_format($item->pivot->price)}}</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-12">
                            <ul class="allItemPriceBox">
                                <li>
                                    <div class="firstColumn">
                                        VAT
                                    </div>
                                    <div class="secondColumn">
                                        Tk. {{currency_format($order->vat_amount)}}
                                    </div>
                                </li>
                                <li>
                                    <div class="firstColumn">
                                        Delivery Fee
                                    </div>
                                    <div class="secondColumn">
                                        Tk. {{currency_format($order->delivery_fee)}}
                                    </div>
                                </li>
                                <li>
                                    <div class="firstColumn">
                                        Grand Total
                                    </div>
                                    <div class="secondColumn">
                                        Tk. {{ currency_format($order->amount) }}
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection