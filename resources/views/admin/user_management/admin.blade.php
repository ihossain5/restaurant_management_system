@extends('layouts.admin.master')
@section('pageCss')
    <style>
        .employee_signature {
            height: 60px;
            border-radius: 50%;
        }

        .view_employee_signature {
            max-height: 220px;
            max-width: 467px;
        }
        .view_signature {
            /* max-height: 220px; */
            max-width: 467px;
        }
        .filter_by_role{
            width: 145px;
        }

    </style>
@endsection
@section('content')
    <div class="preloader">

    </div>

    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-4">
                                <div class="ms-header-text">
                                    <h4 class="mt-0 header-title">All Admins</h4>
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
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($users))
                                        @foreach ($users as $user)
                                            <tr class="user{{ $user->id }}">
                                              
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                                                               
                                                <td>
                                                    <button type='button' class='btn btn-outline-purple'
                                                        onclick='viewEmployee({{ $user->id }})'><i
                                                            class='fa fa-eye'></i></button>
                                                    

                                                </td>

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


    <!-- view  Modal -->
    <div class="modal fade bs-example-modal-center" id="viewModal" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-block">
                    <h5 class="modal-title mt-0 text-center">Admin's Details</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 col-md-12 text-center signature_row mb-3">
                        <div class="ms-form-group">
                            {{-- <label for="name"><strong>Logo:</strong></label> --}}
                            <img src="" id="view_image" class="view_employee_signature">
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group">
                            <label for="name"><strong>Name:</strong></label>
                            <p id="view_name"></p>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group">
                            <label for="name"><strong>Email:</strong></label>
                            <p id="view_email"></p>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group">
                            <label for="name"><strong>Phone:</strong></label>
                            <p id="view_phone"></p>
                        </div>
                    </div>
                   



                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- view  Modal End -->
@endsection
@section('pageScripts')

    <script type='text/javascript'>
        var toastMixin = Swal.mixin({
            toast: true,
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        var config = {
            routes: {
                
                view: "{!! route('admin.show') !!}",
                
            }
        };

       

      $('#userTable').DataTable({
                "ordering": false,
            });


        // view single 
        function viewEmployee(id) {
            $.ajax({
                url: config.routes.view,
                method: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        $('#view_name').text(response.data.name);
                        $('#view_email').text(response.data.email);
                        $('#view_phone').text(response.data.phone);
                       

                        if (response.data.image === null) {
                            $('#view_image').removeAttr('src');
                        } else {
                            $('#view_image').attr('src', '/images/' + response.data.image);
                        }
                        


                        $('#viewModal').modal('show');

                    } //success end

                }
            }); //ajax end
        }




        
        
    </script>
@endsection
