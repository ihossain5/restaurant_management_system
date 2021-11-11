@extends('layouts.frontend.master')
@section('title')
   Forgot Password
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
        .signInContainer{
            min-height: auto;
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
            <div class="col-lg-7 order-0 order-lg-1 text-center align-self-center">
                @if (session()->has('success'))
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
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close closeBtn" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                        </div>
                    </div>
                @endif


                @if ($errors->any())
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
                                @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                            </div>
                            <button type="button" class="btn-close closeBtn" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                    <div class="signInContainer">
                        <img class="signLogo" src="{{ asset('frontend/assets/images/Logos/Emerald Group.svg') }}"
                            alt="">

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-signIn" role="tabpanel"
                                aria-labelledby="pills-signIn-tab">
                                <div class="row formInput">
                                    <form id="passwordResetForm" method="POST" action="{{route('customer.forgot.password.form')}}">@csrf
                                        <div class="col-12 text-start">
                                            <input class="form-control" name="email" type="text" placeholder="Your Email">
                                        </div>
                                       <div class="text-start forgot-password">
                                            <p class="h3 "><a href="{{route('frontend.customer.sign.in')}}">back to login?</a> </p>
                                       </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" class="outlineBtn rounded-pill">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
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
            $("#passwordResetForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },

                },
                messages: {
                    email: {
                        required: 'Please insert your email',
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
                        location.reload();
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
                        location.reload();
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
