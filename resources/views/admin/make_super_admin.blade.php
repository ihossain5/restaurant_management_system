<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Super Admin</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App Icons -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet" type="text/css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.5/sweetalert2.min.css"
        integrity="sha512-gX6K9e/4ewXjtn8Q/oePzgIxs2KPrksR4S2NNMYLxenvF7n7eNon9XbqQxb+5jcqYBVCcncIxqF6fXJYgQtoAg=="
        crossorigin="anonymous" />

    <!-- DataTables -->
    <link href="{{ asset('backend/assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend/assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('backend/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
               .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
    </style>

</head>


<body>

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Begin page -->
    {{-- <div class="accountbg"></div> --}}
    <div id="wrapper">

       <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-4">
                                <div class="ms-header-text">
                                    <h4 class="mt-0 header-title">All Users</h4>
                                </div>
                                 
                               

                            </div>

                            <span class="showError"></span>
                            <table id="userTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                       
                                       
                                     
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Image</th>                     
                                        <th>Is Super Admin</th>               
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($users))
                                        @foreach ($users as $user)
                                            <tr class="user{{ $user->id }}">
                                                
                                            
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                 <td><img class="img-fluid" src="{{asset('images/'.$user->image)}}" style="width: 60px; height: 55px;"></td>
                                               
                                               <td><label class="switch">
                                                <input class="is_admin status{{ $user->id }}" type="checkbox" {{ $user->is_super_admin==1 ? 'checked' : '' }} data-id="{{$user->id}}">
                                                <span class="slider round"></span>
                                              </label></td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                               
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->




        </div><!-- container -->

    </div> <!-- Page content Wrapper -->

    </div>


    <!-- jQuery  -->
    <script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('backend/assets/js/waves.js') }}"></script>
    <script src="{{ asset('backend/assets/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('backend/assets/js/jquery.scrollTo.min.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ asset('backend/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Buttons examples -->
<script src="{{ asset('backend/assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>


<!-- Datatable init js -->
<script src="{{ asset('backend/assets/pages/datatables.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.5/sweetalert2.min.js"
integrity="sha512-+uGHdpCaEymD6EqvUR4H/PBuwqm3JTZmRh3gT0Lq52VGDAlywdXPBEiLiZUg6D1ViLonuNSUFdbL2tH9djAP8g=="
crossorigin="anonymous"></script>
    <script>
          var config = {
            routes: {
                
                make_superadmin: "{!! route('is.superadmin') !!}",
            }
        };
         $('#userTable').DataTable({
                "ordering": false,
            });
        // check if admin status change
 $(document.body).on('click','.is_admin',function(){
              var id=$(this).attr('data-id');
                if($(this).is(":checked")){


                      Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change this status!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: config.routes.make_superadmin,
                    data: {
                      value:1,
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'JSON',
                    success: function(response) {

                         if (response.success === true) {
                            Swal.fire(
                                'Status Changed!',
                                "" + response.data.message + "",
                                'success'
                            )
                            // swal("Done!", response.data.message, "success");
                             
                        } else {
                            Swal.fire("Error!", "Can't change status", "error");
                        }
                    }
                });
                }
                else if (
                      /* Read more about handling dismissals below */
                      result.dismiss === Swal.DismissReason.cancel
                    ) {
                  // alert('hi');
                      if ($('.status' + id + "").prop("checked") == true) {
                            // alert('hello')
                            $('.status' + id + "").prop('checked', false);
                        } 
                        else if ($('.status' + id + "").prop("checked") == false) {
                            // alert('sds')
                            $('.status' + id + "").prop('checked', true);
                        }
                    }

                


        })


            }
                 


                else if($(this).is(":not(:checked)")){



                      Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Change this status!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: config.routes.make_superadmin,
                    data: {
                      value:0,
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'JSON',
                    success: function(response) {

                         if (response.success === true) {
                            Swal.fire(
                                'Status Changed!',
                                "" + response.data.message + "",
                                'success'
                            )
                            // swal("Done!", response.data.message, "success");
                          
                        } else {
                            Swal.fire("Error!", "Can't change status", "error");
                        }
                    }
                });
                }
                else if (
                      /* Read more about handling dismissals below */
                      result.dismiss === Swal.DismissReason.cancel
                    ) {
                  // alert('hi');
                      if ($('.status' + id + "").prop("checked") == true) {
                            // alert('hello')
                            $('.status' + id + "").prop('checked', false);
                        } 
                        else if ($('.status' + id + "").prop("checked") == false) {
                            // alert('sds')
                            $('.status' + id + "").prop('checked', true);
                        }
                    }

               


        })



                }
            });
    </script>

</body>

</html>
