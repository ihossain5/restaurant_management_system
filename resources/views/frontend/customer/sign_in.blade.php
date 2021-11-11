@extends('layouts.frontend.master')
@section('title')
    Sign In
@endsection
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <style>
        .closeBtn{
            top: 6px !important;
        }
        .forgot-password p > a{
            color: black;
        }
    </style>
@endsection

@section('content')
    <!-- Sign In -->
    <section>
        <div class="row">
            <div class="col-lg-5 order-1 order-lg-0">
                <img class="w-100 left-img" src="{{ asset('frontend/assets/images/sign up/image 19.png') }}" alt="">
            </div>
            <div class="col-lg-7 order-0 order-lg-1 text-center">
                @if (session()->has('message'))
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </symbol>
                    </svg>
                    <div class="d-inline-block p-5">
                        <div class="alert alert-success text-center d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                                <use xlink:href="#check-circle-fill" />
                            </svg>
                            <div class="text-center h1">
                                {{ session('message') }}
                            </div>
                        </div>
                    </div>
                @endif

                @if (session()->has('warning'))
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </symbol>
                    </svg>
                    <div class="d-inline-block p-5">
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div class="text-center h1">
                                {{ session('warning') }}
                            </div>
                        </div>
                    </div>
                @endif

                @if (session()->has('error'))
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </symbol>
                    </svg>
                    <div class="d-inline-block p-5">
                        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div class="text-center h1">
                                {{ session('error') }}
                            </div>
                            <button type="button" class="btn-close closeBtn" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                @if (!Auth::guard('customer')->check())
                    <div class="signInContainer">
                        <img class="signLogo" src="{{ asset('frontend/assets/images/Logos/Emerald Group.svg') }}"
                            alt="">
                        <ul class="nav nav-pills signIn-nav mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-signIn-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-signIn" type="button" role="tab" aria-controls="pills-signIn"
                                    aria-selected="true">SIGN IN</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-signUp-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-signUp" type="button" role="tab" aria-controls="pills-signUp"
                                    aria-selected="false">SIGN UP</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-signIn" role="tabpanel"
                                aria-labelledby="pills-signIn-tab">
                                <div class="row formInput">
                                    <div class="col-12">
                                        <p class="signInInfo">Sign in instantly with your Google or Facebook account.</p>

                                        <div class="socialLogin">
                                            <a href="{{ route('login.google') }}">
                                                <button><img
                                                        src="{{ asset('frontend/assets/images/sign up/Google.svg') }}"
                                                        alt=""></button>
                                            </a>
                                            <a href="{{ route('login.facebook') }}">
                                                <button><img
                                                        src="{{ asset('frontend/assets/images/sign up/facebook.svg') }}"
                                                        alt=""></button>
                                            </a>
                                        </div>
                                        <h6>OR</h6>
                                    </div>
                                    <form id="signInForm" method="POST">@csrf
                                        <div class="col-12 text-start">
                                            <input class="form-control" name="email" type="text" placeholder="Your Email">
                                        </div>
                                        <div class="col-12 toggleBtn text-start">
                                            <input class="form-control loginPassword" name="password" type="password"
                                                placeholder="Password">
                                            <span class="passToggleLogin1Btn">Show</span>
                                        </div>
                                       <div class="text-start forgot-password">
                                            <p class="h3 "><a href="{{route('customer.forgot.password')}}">Forgot your password?</a> </p>
                                       </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" class="outlineBtn rounded-pill">Sign In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-signUp" role="tabpanel"
                                aria-labelledby="pills-signUp-tab">
                                <div class="row formInput">
                                    <div class="col-12 ">
                                        <p class="signInInfo">Sign Up instantly with your social account</p>
                                        <div class="socialLogin">
                                            <a href="{{ route('login.google') }}">
                                                <button><img
                                                        src="{{ asset('frontend/assets/images/sign up/Google.svg') }}"
                                                        alt=""></button>
                                            </a>

                                            <button><img src="{{ asset('frontend/assets/images/sign up/facebook.svg') }}"
                                                    alt=""></button>
                                            </a>
                                        </div>
                                        <h6>OR</h6>
                                    </div>
                                    <form id="signUpForm" method="POST">@csrf
                                        <div class="col-12 text-start">
                                            <input class="form-control" name="email" type="text" placeholder="Your Email">
                                        </div>
                                        <div class="col-md-12 text-start">
                                            <input class="form-control" name="name" type="text" placeholder="Full Name">
                                        </div>
                                        <div class="col-md-12 text-start">
                                            <input class="form-control" name="contact" type="text"
                                                placeholder="Contact Number">
                                        </div>
                                        <div class="col-12 toggleBtn text-start">
                                            <input class="form-control loginPassword" name="password" type="password"
                                                placeholder="Password">
                                            <span class="passToggleLogin1Btn">Show</span>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" class="outlineBtn rounded-pill">Sign Up</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
@section('pageScripts')
    <script>
        var config = {
            routes: {
                signIn: "{!! route('customer.sign.in') !!}",
                signUp: "{!! route('customer.sign.up') !!}",

            }
        };
        $(document).ready(function() {
            // add form validation
            $("#signInForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },

                },
                messages: {
                    email: {
                        required: 'Please insert your email',
                    },
                    password: {
                        required: 'Please insert your password ',
                    },
                },
                errorPlacement: function(label, element) {
                    label.addClass('h3 text-danger');
                    label.insertAfter(element);
                },
            });
            // update form validation
            $("#signUpForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    name: {
                        required: true,
                    },
                    contact: {
                        required: true,
                        digits: true,
                        minlength: 11,
                        maxlength: 11
                    },


                },
                messages: {
                    email: {
                        required: 'Please insert your email',
                    },
                    password: {
                        required: 'Please insert your password ',
                    },
                    name: {
                        required: 'Please insert your name ',
                    },
                    contact: {
                        required: 'Please insert your contact number ',
                    },

                },
                errorPlacement: function(label, element) {
                    label.addClass('h3 text-danger');
                    label.insertAfter(element);
                },
            });
        });
        //end

        // add  request

        $(document).on('submit', '#signInForm', function(event) {
            event.preventDefault();
            $.ajax({
                url: config.routes.signIn,
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        // toastr["success"](response.data.message)
                        window.location.href = response.data.url;
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
        });
        $(document).on('submit', '#signUpForm', function(event) {
            event.preventDefault();
            $.ajax({
                url: config.routes.signUp,
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        // toastr["success"](response.data.message)
                        window.location.href = response.data.url;
                    } else {
                        toastr["error"](response.data.message)

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

        //request end
    </script>
@endsection
