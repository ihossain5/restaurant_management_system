@extends('layouts.frontend.master')
@section('title')
Sign In
@endsection

@section('content')

   <!-- Sign In -->

   <section>
    <div class="row">
        <div class="col-lg-5 order-1 order-lg-0">
            <img class="w-100 left-img" src="{{asset('frontend/assets/images/sign up/image 19.png')}}" alt="">
        </div>

        <div class="col-lg-7 order-0 order-lg-1">
            @if (session()->has('message'))
            <div class="alert alert-success text-center text-dark mt-3 alert-solid alert-dismissible shadow-sm p-3 mb-5 rounded"
                role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @guest
            
        <div class="signInContainer">
            <img class="signLogo" src="{{asset('frontend/assets/images/Logos/Emerald Group.svg')}}" alt="">

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
                            <p class="signInInfo">Sign in instantly with your social account</p>

                            <div class="socialLogin">
                                <button><img src="{{asset('frontend/assets/images/sign up/Google.svg')}}" alt=""></button>
                                <button><img src="{{asset('frontend/assets/images/sign up/facebook.svg')}}" alt=""></button>
                            </div>

                            <h6>OR</h6>
                        </div>
                        <form id="signInForm" method="POST">@csrf
                        <div class="col-12">
                            <input class="form-control" name="email" type="text" placeholder="Your Email">
                        </div>
                        <div class="col-12 toggleBtn">
                            <input class="form-control loginPassword" name="password" type="password" placeholder="Password">
                            <span class="passToggleLogin1Btn">Show</span>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="outlineBtn rounded-pill">Sign In</button>
                        </div>
                    </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-signUp" role="tabpanel" aria-labelledby="pills-signUp-tab">
                    <div class="row formInput">
                        <div class="col-12">
                            <p class="signInInfo">Sign Up instantly with your social account</p>
                            <div class="socialLogin">
                                <button><img src="{{asset('frontend/assets/images/sign up/Google.svg')}}" alt=""></button>
                                <button><img src="{{asset('frontend/assets/images/sign up/facebook.svg')}}" alt=""></button>
                            </div>

                            <h6>OR</h6>
                        </div>
                        <form id="signUpForm" method="POST">@csrf
                        <div class="col-12">
                            <input class="form-control" name="email" type="text" placeholder="Your Email">
                        </div>

                        <div class="col-md-12">
                            <input class="form-control" name="name" type="text" placeholder="First Name">
                        </div>
                   

                        <div class="col-12 toggleBtn">
                            <input class="form-control loginPassword" name="password" type="password" placeholder="Password">
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
        @endguest
           
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
                    label.addClass('mt-2 text-danger');
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
                    },
                    name: {
                        required: true,
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
                        required: 'Please insert your first name ',
                    },

                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
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