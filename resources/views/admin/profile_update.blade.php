@extends('layouts.admin.master')
@section('pageCss')
  
@endsection
@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                           
                            <div class="d-flex justify-content-center mb-4">
                                <div class="ms-header-text">
                                    <h4 class="mt-0 header-title">Profile</h4>
                                </div>
                                
                                    {{-- <a type="button"
                                        class="btn btn-outline-purple float-right waves-effect waves-light" name="button"href="{{route('password.change')}}"
                                        > Change Password
                                    </a> --}}
                                
                               

                            </div>
                            @if ($errors->any())
                                <div class=" mt-3">
                                    <ul class="mt-3 list-disc list-inside text-danger text-sm text-red-600">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-solid text-center text-dark alert-dismissible shadow-sm p-3 mb-5 rounded"
                                    role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="ms-panel-body">
                                <p class="ms-directions"></p>

                                 <div class="col-lg-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
            {{-- 
                                            <h4 class="mt-0 header-title">Profile</h4> --}}
                                            
            
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-pills nav-justified" role="tablist">
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link active" data-toggle="tab" href="#home-1" role="tab">Information Update</a>
                                                </li>
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">Change Password</a>
                                                </li>
                                               
                                            </ul>
            
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane active p-3" id="home-1" role="tabpanel">
                                             

                                <div class="ms-panel-body">
                                    <form method="POST" action="{{ route('profile.update') }}" id="changeProfile"
                                        enctype="multipart/form-data"> @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Image(200*200)</label>
                                                    <div class="custom-file profile_image">
                                                        <input type="file" name="image" id="profile_image"
                                                            class="custom-file-input input_image"
                                                            data-errors-position="outside"
                                                            data-allowed-file-extensions='["jpg", "png"]'
                                                            data-max-file-size="0.6M">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="old">Name</label>
                                                    <input type="name" name="name" class="form-control" id="old"
                                                        value="{{ $user->name ?? '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="name" name="email" class="form-control" id="email"
                                                        value="{{ $user->email ?? '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone">Phone</label>
                                                    <input type="name" name="phone" class="form-control" id="phone"
                                                        value="{{ $user->contact ?? '' }}">
                                                </div>
                                                
                                            </div>
                                        </div>


                                       
                                         <div class="d-flex justify-content-center">
                                            <button class="btn btn-purple mt-4 d-block" type="submit">Update</button>
                                        </div>
                                    </form>

                                </div>
                                                </div>
                                                <div class="tab-pane p-3" id="profile-1" role="tabpanel">
                                     <div class="ms-panel-body">
                                    <form method="POST" action="{{ route('password.update') }}" id="changePassword"> @csrf
                                        <div class="form-group col-md-8 offset-2">
                                            <label for="old">Current Password</label>
                                            <input type="password" name="old_password" class="form-control" id="old">
                                        </div>
                                        <div class="form-group col-md-8 offset-2">
                                            <label for="new">New Password</label>
                                            <input type="password" name="password" class="form-control" id="new">
                                        </div>
                                        <div class="form-group col-md-8 offset-2">
                                            <label for="confirm">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                id="confirm">
                                        </div>
                                        {{-- <input type="text" name="password" class="form-control mt-5" id=""> --}}
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-purple mt-4 d-block" type="submit">Update</button>
                                        </div>
                                        
                                    </form>

                                </div>
                                                </div>
                                               
                                            </div>
            
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->




        </div><!-- container -->

    </div> <!-- Page content Wrapper -->
@endsection
@section('pageScripts')
   
    <script>
        $('.dropify').dropify({
            error: {
                'fileSize': 'The file size is too big ( 600KB  max).',
            }
        });
        var data = {!! $user !!};
        var path = "{{ url('/') }}" + '/images/';
        console.log(path);
        if (data.photo) {
            var img_url = path + data.photo;
            $("#profile_image").attr("data-height", 200);
            // $("#profile_image").attr("data-min-width", 450);
            $("#profile_image").attr("data-default-file", img_url);

            $('.profile_image').find('.dropify-wrapper').removeClass("dropify-wrapper").addClass(
                "dropify-wrapper has-preview");
            $('.profile_image').find(".dropify-preview").css('display', 'block');
            $('.profile_image').find('.dropify-render').html('').html('<img src=" ' + img_url +
                '">')
        } else {
            $('#profile_image').find(".dropify-preview .dropify-render img").attr("src", "");
        }
        $('.input_image').dropify({
            error: {
                'fileSize': 'The file size is too big ( 600KB  max).',
            }
        });
        //  validation 
        $(document).ready(function() {
            $("#changeProfile").validate({
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
                    phone: {
                        required: true,
                        maxlength: 20,
                    },
                    designation: {
                        required: true,
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
                    phone: {
                        required: 'Please insert your phone number',
                    },
                    designation: {
                        required: 'Please insert your designation ',
                    },



                },
                errorPlacement: function(label, element) {
                    label.addClass('err-msg mt-2 text-danger ');
                    label.insertAfter(element);
                },

            });
        });
        // end

        $(document).ready(function() {
            $("#changePassword").validate({
                rules: {
                    old_password: {
                        required: true,

                    },

                    password: {
                        required: true,
                        minlength: 6,
                    },
                    password_confirmation: {

                        equalTo: '[name="password"]'
                    },


                },
                messages: {
                    old_password: {
                        required: 'Please insert your current password',

                    },

                    password: {
                        required: 'Please insert  new password',
                        minlength: 'Password must consist of at least 6 characters',
                    },
                    password_confirmation: {
                        equalTo: 'Password and confirm password does not match',
                    }



                },
                errorPlacement: function(label, element) {
                    label.addClass('err-msg mt-2 text-danger ');
                    label.insertAfter(element);
                },

            });
        });
        // end


    </script>
@endsection
