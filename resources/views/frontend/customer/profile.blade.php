@extends('layouts.frontend.master')
@section('title')
    Profile
@endsection
@section('pageCss')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
@endsection
@section('content')
    <!-- Profile -->
    <section>
        <div class="row">
            <div class="col-lg-7">
                <div class="profile">
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
                    <h1>your profile</h1>
                    <div class="profile-image-box position-relative">
                        <div class="row">
                            <div class="col-12">
                                <img src="{{ asset($customer->photo == null ? 'images/default.jpg' : 'images/'.$customer->photo) }}"
                                    alt="" class="profile-img" id="uplodedImg">
                                <label class="file-upload-label" for="fileUpload">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                        fill="none">
                                        <path
                                            d="M9.37333 6.01333L9.98667 6.62667L3.94667 12.6667H3.33333V12.0533L9.37333 6.01333ZM11.7733 2C11.6067 2 11.4333 2.06667 11.3067 2.19333L10.0867 3.41333L12.5867 5.91333L13.8067 4.69333C14.0667 4.43333 14.0667 4.01333 13.8067 3.75333L12.2467 2.19333C12.1133 2.06 11.9467 2 11.7733 2ZM9.37333 4.12667L2 11.5V14H4.5L11.8733 6.62667L9.37333 4.12667Z"
                                            fill="#1A1A1A" />
                                    </svg>
                                </label>
                                <form method="POST" id="imageUpdateForm">@csrf
                                    <input type="file" name="photo" id="fileUpload" accept="image/*">
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <h2>account information</h2>
                        </div>
                        <div class="text-end">
                            <button onclick="personalInfoEdit()" class="perosnalEditBtn editBtn"><img
                                    src="{{ asset('frontend/assets/images/profile/edit.svg') }}" alt=""></button>
                        </div>
                    </div>

                    <div class="personalInfo">
                        <div class="row">
                            <!-- <div class="col-12">
                                                            <img src="assets/images/profile/profile-img.png" alt="" class="profile-img">
                                                        </div> -->
                            <div class="col-12 pb-3">
                                <h5>Name</h5>
                                <p class="customerName">{{ $customer->name }}</p>
                            </div>
                            <div class="col-12 pb-3">
                                <h5>Email</h5>
                                <p class="customerEmail">{{ $customer->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="personalInfoForm d-none pt-3">
                        <div class="row formInput profile-input">
                            <form method="POST" id="accountInfoForm">@csrf
                                <div class="col-12">
                                    <input class="form-control customerNameEdit" name="name" type="text"
                                        placeholder="Your Name">
                                </div>
                                <div class="col-12">
                                    <input class="form-control customerEmailEdit" name="email" type="text"
                                        placeholder="Your Email">
                                </div>

                                <div class="col-12 text-end">
                                    {{-- <button onclick="personalInfoSave()" class="rounded-pill">Save Changes</button> --}}
                                    <button type="submit" class="rounded-pill">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="d-flex justify-content-between delAddress">
                        <div>
                            <h2>Delivery address</h2>
                        </div>
                        <div class="text-end">
                            <button onclick="deliveryInfoEdit()" class="deliveryEditBtn editBtn"><img
                                    src="{{ asset('frontend/assets/images/profile/edit.svg') }}" alt=""></button>
                        </div>
                    </div>

                    <div class="deliveryInfo">
                        <div class="row">
                            <div class="col-12 pb-3">
                                <h5>Address</h5>
                                <p class="customerAddress">{{ $customer->address ?? 'N/A' }}</p>
                            </div>
                            <div class="col-12 pb-3">
                                <h5>Mobile Number</h5>
                                <p class="customerContact">{{ $customer->contact ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="deliveryInfoForm d-none pt-3">
                        <div class="row formInput profile-input">
                            <form method="POST" id="deliveryInfoForm">@csrf
                                <div class=" col-12">
                                    <input class="form-control customerAddressEdit" name="address" type="text"
                                        placeholder="Your Delivery Address">
                                </div>
                                <div class="col-12">
                                    <input class="form-control customerContactEdit" name="contact" type="text"
                                        placeholder="Your Phone Number">
                                </div>
                                <div class="col-12 text-end">
                                    {{-- <button onclick="deliveryInfoSave()" class="rounded-pill">Save Changes</button> --}}
                                    <button type="submit" class="rounded-pill">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-5">
                <img class="w-100 left-img" src="{{ asset('frontend/assets/images/profile/image 20.png') }}" alt="">
            </div>
        </div>
    </section>
@endsection
@section('pageScripts')
    <script>
        var config = {
            routes: {
                imageUpdate: "{!! route('customer.profile.photo.update') !!}",
                deliveryInfoUpdate: "{!! route('customer.delivery.info.update') !!}",
                accountInfoUpdate: "{!! route('customer.account.info.update') !!}",
                addToCart: "{!! route('frontend.cart.add') !!}",
                updateCart: "{!! route('frontend.cart.update') !!}",
                decreaseCartQty: "{!! route('frontend.cart.decrease.quantity') !!}",
                deleteCart: "{!! route('frontend.cart.delete') !!}",
                changeRestaurant: "{!! route('frontend.cart.change.restaurant') !!}",
                addToCartRestaurant: "{!! route('frontend.cart.add.busy.restaurant') !!}",
            }
        };

        $(document).ready(function() {
            // add form validation
            $("#accountInfoForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 100,
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 100,
                    },
                },
                messages: {
                    name: {
                        required: 'Please insert your name',
                    },
                    email: {
                        required: 'Please insert your email',
                    },
                },
                errorPlacement: function(label, element) {
                    label.addClass(' text-danger h3');
                    label.insertAfter(element);
                },
            });
            // update form validation
            $("#deliveryInfoForm").validate({
                rules: {
                    address: {
                        // required: true,
                        maxlength: 100,
                    },
                    contact: {
                        required: true,
                        digits: true,
                        maxlength: 11,
                        minlength: 11,
                        
                    },
                },
                messages: {
                    contact: {
                        required: 'Please insert your mobile number',
                    },
                },
                errorPlacement: function(label, element) {
                    label.addClass('text-danger h3');
                    label.insertAfter(element);
                },
            });
        });

        // edit profile image 
       
        var url;
        $('#fileUpload').change(function() {
             url = window.URL.createObjectURL(this.files[0]);
            $("#imageUpdateForm").submit();
        });

        $(document).on('submit', '#imageUpdateForm', function(e) {
            e.preventDefault();
            $.ajax({
                url: config.routes.imageUpdate,
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        $('#uplodedImg').attr('src', url);
                        toastr["success"](response.data.message)

                    } //success end
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastr["error"](response.data.message)
                    }
                },
            }); //ajax end
        });

        function deliveryInfoSave() {
            $.ajax({
                url: config.routes.deliveryInfoUpdate,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {

                        $('#uplodedImg').attr('src', url);
                    } //success end
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastr["error"](response.data.message)
                    }
                },
            }); //ajax end
        }

        $(document).on('submit', '#deliveryInfoForm', function(e) {
            e.preventDefault();
            $.ajax({
                url: config.routes.deliveryInfoUpdate,
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        $('.deliveryInfo').removeClass('d-none');
                        $('.deliveryInfoForm').addClass('d-none');
                        $('.deliveryEditBtn').removeClass('d-none');
                        $('.customerAddress').html(response.data.address);
                        $('.customerContact').html(response.data.contact);
                        toastr["success"](response.data.message)

                    } //success end
                    else{
                        toastr["error"](response.data.error)
                    }
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastr["error"](response.data.message)
                    }
                },
            }); //ajax end
        });

        $(document).on('submit', '#accountInfoForm', function(e) {
            e.preventDefault();
            $.ajax({
                url: config.routes.accountInfoUpdate,
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        $('.personalInfo').removeClass('d-none');
                        $('.personalInfoForm').addClass('d-none');
                        $('.perosnalEditBtn').removeClass('d-none')

                        $('.customerName').html(response.data.name);
                        $('.customerEmail').html(response.data.email);
                        toastr["success"](response.data.message)

                    } //success end
                    else{
                        toastr["error"](response.data.error)
                    }
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastr["error"](response.data.message)
                    }
                },
            }); //ajax end
        });
    </script>
@endsection
