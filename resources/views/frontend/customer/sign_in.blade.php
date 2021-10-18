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
                            <div class="col-12">
                                <input class="form-control" type="text" placeholder="Your Email">
                            </div>
                            <div class="col-12 toggleBtn">
                                <input class="form-control loginPassword" type="password" placeholder="Password">
                                <span class="passToggleLogin1Btn">Show</span>
                            </div>

                            <div class="col-12 text-center">
                                <button class="outlineBtn rounded-pill">Sign In</button>
                            </div>
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
                            <div class="col-12">
                                <input class="form-control" type="text" placeholder="Your Email">
                            </div>

                            <div class="col-md-6">
                                <input class="form-control" type="text" placeholder="First Name">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="text" placeholder="Last Name">
                            </div>

                            <div class="col-12 toggleBtn">
                                <input class="form-control loginPassword" type="password" placeholder="Password">
                                <span class="passToggleLogin1Btn">Show</span>
                            </div>

                            <div class="col-12 text-center">
                                <button class="outlineBtn rounded-pill">Sign Up</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection