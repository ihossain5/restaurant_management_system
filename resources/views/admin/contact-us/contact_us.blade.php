@extends('layouts.admin.master')
@section('page-header')
    Contact Us Section
@endsection
@section('pageCss')
    <style>

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
                                    <h4 class="mt-0 header-title">Contact Us</h4>
                                </div>

                                {{-- <button type="button" class="btn btn-outline-purple float-right waves-effect waves-light"
                                    name="button" id="addButton" data-toggle="modal" data-target="#add"> Add
                                    New
                                </button> --}}



                            </div>

                            <span class="showError"></span>
                            <div class="table-responsive">
                                <table id="ContactUsTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Contact</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($contacts))
                                            @foreach ($contacts as $contact)
                                                <tr class="contact_us{{ $contact->contact_us_id }}">
                                                    <td>{{ $contact->contact }}</td>
                                                    <td>{{ $contact->email }}</td>
                                                    <td>

                                                        <button type='button' class='btn btn-outline-dark'
                                                            onclick='viewContactUs({{ $contact->contact_us_id }})'><i
                                                                class='fa fa-eye'></i></button>
                                                        <button type='button' class='btn btn-outline-info '
                                                            onclick='editContactUs({{ $contact->contact_us_id }})'><i
                                                                class='mdi mdi-pencil'></i></button>


                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->




        </div><!-- container -->

    </div> <!-- Page content Wrapper -->



    <!-- Edit  Modal -->
    <div class="modal fade bs-example-modal-center" id="edit_modal" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-block">
                    <h5 class="modal-title mt-0 text-center">Update Contect Info</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="updateContactUsForm" method="POST"> @csrf
                        <input type="hidden" name="hidden_id" id="hidden_id">

                        <div class="form-group">
                            <label>Contact</label>
                            <input type="text" class="form-control" id="edit_contact" name="contact"
                                placeholder="Type name" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" id="edit_email" name="email"
                                placeholder="Type name" />

                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-success waves-effect waves-light">
                                    Update
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Edit  Modal End -->
    <!-- view  Modal -->
    <div class="modal fade bs-example-modal-center" id="viewModal" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-block">
                    <h5 class="modal-title mt-0 text-center"> Contect Details</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 col-md-12 text-center mb-3">
                        <div class="ms-form-group">
                            {{-- <label for="name"><strong>Logo:</strong></label> --}}
                            <img src="" id="view_image" style="width: 100%;">
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 text-center mb-3">
                        <div class="ms-form-group" style="font-size: 16px;">
                            <span class="badge badge-primary  p-1 view_role"></span>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group">
                            <label for="name"><strong>Contact:</strong></label>
                            <p id="view_contact"></p>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group">
                            <label for="name"><strong>Email:</strong></label>
                            <p id="view_email"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" data-dismiss="modal" class="btn btn-block btn-success waves-effect waves-light">
                        Done
                    </button>
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
                edit: "{!! route('contact.us.edit') !!}",
                view: "{!! route('contact.us.show') !!}",
                update: "{!! route('contact.us.update') !!}",
                delete: "{!! route('contact.us.delete') !!}",
            }
        };

        $('#addButton').on('click', function() {
            $('.dropify-preview').hide();
            $('.ContactUsAddForm').trigger('reset');
        });

        var imagesUrl = '{!! URL::asset('/images/') !!}/';
        $(document).ready(function() {
            $('#ContactUsTable').DataTable({
                "ordering": false,
            });
            $('.dropify').dropify();
            $('.signature_input_box').hide();
        });




        $(document).ready(function() {
            // add form validation
            $(".ContactUsAddForm").validate({
                rules: {
                    heading: {
                        required: true,
                        maxlength: 100,
                    },
                    description: {
                        required: true,
                        maxlength: 10000,
                    },

                    pic: {
                        required: true,
                    },
                },
                messages: {
                    heading: {
                        required: 'Please insert hero section heading',
                    },
                    description: {
                        required: 'Please insert hero section description',
                    },
                    pic: {
                        required: 'Please upload hero section photo',
                    },
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
                    label.insertAfter(element);
                },
            });
            // update form validation
            $(".updateContactUsForm").validate({
                rules: {
                    contact: {
                        required: true,
                        maxlength: 100,
                    },
                    email: {
                        required: true,
                        email:true,
                        maxlength: 100,
                    },
                },
                messages: {
                    heading: {
                        required: 'Please insert hero section heading',
                    },
                    description: {
                        required: 'Please insert hero section description',
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
        $(document).on('submit', '.ContactUsAddForm', function(event) {
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
                        var ContactUsTable = $('#ContactUsTable').DataTable();
                        var row = $('<tr>')
                            .append(`<td>` + response.data.heading + `</td>`)
                            .append(`<td>` + response.data.description + `</td>`)
                            .append(`<td><img class="img-fluid" src="${imagesUrl}` +
                                `${response.data.image}" style='width: 60px; height: 55px;'></td>`)
                            .append(`<td><button type='button' class='btn btn-outline-dark' onclick='viewContactUs(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-info' onclick='editContactUs(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>
                           
                         `)
                        //  <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteContactUs(${response.data.id})">
                        //         <i class="mdi mdi-delete "></i>
                        //     </button></td>

                        // ContactUsTable.row.add(row).node();
                        var contact_us_row = ContactUsTable.row.add(row).node();
                        $('#ContactUsTable tbody').prepend(row);
                        $(contact_us_row).addClass('contact_us' + response.data.id + '');
                        $('.ContactUsAddForm').trigger('reset');
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
                            title: "" + response.data.error + ""
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

        //request end


        // view single 
        function viewContactUs(id) {
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
                        $('#view_contact').text(response.data.contact);
                        $('#view_email').text(response.data.email);
                        $('#viewModal').modal('show');

                    } //success end

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
            }); //ajax end
        }

        function editContactUs(id) {
            $.ajax({
                url: config.routes.edit,
                method: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        $('#edit_contact').val(response.data.contact)
                        $('#edit_email').val(response.data.email)
                        $('#hidden_id').val(response.data.contact_us_id)
                       $('#edit_modal').modal('show');

                    } //success end

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
            
            $(document).off('submit', '.updateContactUsForm');
            $(document).on('submit', '.updateContactUsForm', function(event) {
                event.preventDefault();
                $.ajax({
                    url: config.routes.update,
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {

                        if (response.success == true) {
                            $('.contact_us' + response.data.id).html(
                                `
                                <td>${response.data.contact}</td>
                                <td>${response.data.email}</td>   
                                <td><button type='button' class='btn btn-outline-dark' onclick='viewContactUs(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-info' onclick='editContactUs(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>
                           
                            </td>
                                `
                            );
                            if (response.data.message) {
                                $('#edit_modal').modal('hide');
                                toastMixin.fire({
                                    icon: 'success',
                                    animation: true,
                                    title: "" + response.data.message + ""
                                });
                                $('.updateContactUsForm')[0].reset();
                            }


                        } else {
                            toastMixin.fire({
                                icon: 'error',
                                animation: true,
                                title: "" + response.data.error + ""
                            });

                        }

                    }, //success end
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
            });

        }



        // delete slider
        function deleteContactUs(id) {
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
                                toastMixin.fire({
                                    icon: 'success',
                                    animation: true,
                                    title: "" + response.data.message + ""
                                });
                                $('#ContactUsTable').DataTable().row('.contact_us' + response.data
                                        .id)
                                    .remove()
                                    .draw();
                            } else {
                                Swal.fire("Error!", "" + response.message + "", "error");
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
