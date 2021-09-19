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
                                
                                                                   
                                <button type="button" class="btn btn-outline-purple float-right waves-effect waves-light"
                                name="button" id="addButton" data-toggle="modal" data-target="#add"> Add
                                New
                            </button>
                            </div>

                            <span class="showError"></span>
                            <table id="adminTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                       
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Phone</th>              
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($users))
                                        @foreach ($users as $user)
                                            <tr class="admin{{ $user->id }}">
                                                <td>
                                                    @if ($user->photo == null)
                                                        <img class='img-fluid' src="{{ asset('images/default.png') }}"
                                                            alt="{{ $user->name }}" style='width: 60px; height: 55px;'>
                                                    @else
                                                        <img class='img-fluid'
                                                            src="{{ asset('images/' . $user->photo) }}"
                                                            alt="{{ $user->name }}" style='width: 60px; height: 55px;'>
                                                    @endif
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->sex }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->contact }}</td>
                                                                                               
                                                <td>
                                                    <button type='button' class='btn btn-outline-dark'
                                                        onclick='viewAdmin({{ $user->id }})'><i
                                                            class='fa fa-eye'></i></button>
                                                    
                                                            <button type='button' name='delete' class="btn btn-outline-danger "
                                                            onclick="deleteAdmin({{ $user->id }})"><i
                                                                class="mdi mdi-delete "></i></button>
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


    <!-- Add  Modal -->
    <div class="modal fade bs-example-modal-center" id="add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-block">
                    <h5 class="modal-title mt-0 text-center">Add a new Admin</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="adminAddForm" method="POST"> @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Type name" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Type email" />
                        </div>

                        <div class="form-group mt-3">
                            <div>
                                <button type="submit" class="btn btn-block btn-success waves-effect waves-light">
                                    Submit
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Add  Modal End -->    
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
        var config = {
            routes: {
                add: "{!! route('admin.store') !!}",
                view: "{!! route('admin.show') !!}",
                delete: "{!! route('admin.delete') !!}",
            }
        };
        // add form validation
        $(document).ready(function() {
            $(".adminAddForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 50,
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 50,
                    },

                },
                messages: {
                    name: {
                        required: 'Please insert admin name',
                    },
                    email: {
                        required: 'Please insert admin email',
                    },
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
                    label.insertAfter(element);
                },
            });
        });
        //end
       

      $('#adminTable').DataTable({
                "ordering": false,
            });


            $(document).on('submit', '.adminAddForm', function(event) {
            event.preventDefault();
            $.ajax({
                url: config.routes.add,
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(response) {

                    if (response.success == true) {
                        var managerTable = $('#adminTable').DataTable();
                        var row = $('<tr>')
                            .append(`<td><img class="img-fluid" src="${imagesUrl}` + '/' +
                                `${response.data.photo !=null ? response.data.photo : 'default.png'}" style='width: 60px; height: 55px;'></td>`
                            )
                            .append(`<td>` + response.data.name + `</td>`)
                            .append(`<td>` + response.data.sex + `</td>`)
                            .append(`<td>` + response.data.email + `</td>`)
                            .append(`<td>` + response.data.phone + `</td>`)


                            .append(`<td><button type='button' class='btn btn-outline-dark' onclick='viewAdmin(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>

                           
                            <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteAdmin(${response.data.id})">
                                <i class="mdi mdi-delete "></i>
                            </button></td>`)


                        var manager_row = managerTable.row.add(row).draw().node();
                        $('#adminTable tbody').prepend(row);
                        $(manager_row).addClass('manager' + response.data.id + '');

                        $('.adminAddForm').trigger('reset');
                        if (response.data.message) {
                            $('#add').modal('hide');
                            toastMixin.fire({
                                icon: 'success',
                                animation: true,
                                title: "" + response.data.message + ""
                            });

                        }


                    } else {
                        toastMixin.fire({
                            icon: 'error',
                            animation: true,
                            title: "" + response.data.message + ""
                        });

                    }
                }, //success end
                error: function(error) {
                    if (error.status == 422) {
                        $.each(error.responseJSON.errors, function(i, message) {
                            toastMixin.fire({
                                icon: 'error',
                                animation: true,
                                title: "" + message + ""
                            });
                        });

                    }
                },
            });
        });
        // view single 
        function viewAdmin(id) {
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


    // delete 
    function deleteAdmin(id) {
            // alert(id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: config.routes.delete,
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            if (response.success === true) {
                                $('#adminTable').DataTable().row('.admin' + response.data.id)
                                    .remove()
                                    .draw();
                                toastMixin.fire({
                                    icon: 'success',
                                    animation: true,
                                    title: "" + response.data.message + ""
                                });
                            }
                        },
                        error: function(error) {
                            if (error.status == 404) {
                                toastMixin.fire({
                                    icon: 'error',
                                    animation: true,
                                    title: "" + 'Data not found' + ""
                                });


                            }
                        },
                    });

                }
            })


        }
        //end

        
        
    </script>
@endsection
