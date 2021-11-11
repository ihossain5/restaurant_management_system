@extends('layouts.admin.master')
@section('page-header')
    Restaurant Managers
@endsection
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

        .filter_by_role {
            width: 100px;
        }

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

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
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
                                    <h4 class="mt-0 header-title">Restaurant Managers</h4>
                                </div>

                                <button type="button" class="btn btn-outline-purple float-right waves-effect waves-light"
                                    name="button" id="addButton" data-toggle="modal" data-target="#add"> Add
                                    New
                                </button>
                            </div>
                            <table id="managerTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Restaurant Name</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($managers))
                                        @foreach ($managers as $manager)
                                            <tr class="manager{{ $manager->id }}">
                                                <td>
                                                    @if ($manager->photo == null)
                                                        <img class='img-fluid' src="{{ asset('images/default.png') }}"
                                                            alt="{{ $manager->name }}" style='width: 60px; height: 55px;'>
                                                    @else
                                                        <img class='img-fluid'
                                                            src="{{ asset('images/' . $manager->photo) }}"
                                                            alt="{{ $manager->name }}" style='width: 60px; height: 55px;'>
                                                    @endif
                                                </td>
                                                <td>{{ $manager->restaurant->name ?? 'N/A' }}</td>
                                                <td>{{ $manager->name ?? 'N/A' }}</td>
                                                <td>{{ $manager->sex ?? 'N/A' }}</td>
                                                <td>{{ $manager->email ?? 'N/A' }}</td>
                                                <td>{{ $manager->contact ?? 'N/A' }}</td>
                                                <td>

                                                    <button type='button' class='btn btn-outline-dark'
                                                        onclick='viewManager({{ $manager->id }})'><i
                                                            class='fa fa-eye'></i></button>
                                                    <button type='button' class='btn btn-outline-info '
                                                        onclick='editManager({{ $manager->id }})'><i
                                                            class='mdi mdi-pencil'></i></button>
                                                    {{-- <button type='button' name='delete' class="btn btn-outline-danger "
                                                        onclick="deleteManager({{ $manager->id }})"><i
                                                            class="mdi mdi-delete "></i></button> --}}
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
                    <h5 class="modal-title mt-0 text-center">Add a new Restaurant Manager</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="managerAddForm" method="POST"> @csrf
                        <div class="form-group">
                            <label>Select Restaurant</label>
                            <select name="restaurant" id="" class="form-control restaurant_select_box">
                                <option value="">Select Restaurant</option>
                                @foreach ($restaurants as $restaurant)
                                    <option value="{{ $restaurant->restaurant_id }}">{{ $restaurant->name }}</option>
                                @endforeach
                            </select>
                        </div>
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

    <!-- Edit  Modal -->
    <div class="modal fade bs-example-modal-center" id="edit_modal" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-block">
                    <h5 class="modal-title mt-0 text-center">Update Manager's Info</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="updateManagerForm" method="POST"> @csrf
                        <input type="hidden" name="hidden_id" id="hidden_id">
                        <div class="form-group">
                            <label>Select Restaurant</label>
                            <select name="restaurant" id="restaurant_id" class="form-control restaurant_select_box">
                                <option value="" selected class="restaurantName"></option>
                                @foreach ($restaurants as $restaurant)
                                    <option value="{{ $restaurant->restaurant_id }}">{{ $restaurant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" placeholder="Type name" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" id="edit_email"
                                placeholder="Type email" />
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-success ">
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
                    <h5 class="modal-title mt-0 text-center">Restaurant Manager Details</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group">
                            <p class="pt-2 pb-2">
                                <strong>Name:</strong> <span id="view_name"></span> <br>
                                <strong>Restaurant Name:</strong> <span id="view_restaurant_name"></span><br>
                                <strong>Gender:</strong> <span id="view_gender"></span><br>
                                <strong>Email:</strong> <span id="view_email"></span><br>
                                <strong>Phone:</strong> <span id="view_phone"></span><br>
                                <label for="name"><strong>Photo:</strong></label> <br>
                                <img src="" id="view_image" style="width: 100%;">
                            </p>
                        </div>
                        <div class="form-group">
                            <div>


                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12 mt-5">
                    <div class="row">
                        <div class="col-md-6">
                            <button data-toggle="modal" class="btn-custom dangerBtn  mb-3 delete_btn"><i class="mdi mdi-delete "></i>
                            Delete
                        </button>
                        </div>
                        <div class="col-md-6 text-right">
                        <button data-dismiss="modal" class="btn btn-custom btnAccept mb-3 "> Done</button>
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
                add: "{!! route('restaurant.manager.store') !!}",
                edit: "{!! route('restaurant.manager.edit') !!}",
                view: "{!! route('restaurant.manager.show') !!}",
                update: "{!! route('restaurant.manager.update') !!}",
                delete: "{!! route('restaurant.manager.delete') !!}",
                is_admin: "{!! route('is.admin') !!}",
            }
        };

        $('#addButton').on('click', function() {
            $('.dropify-preview').hide();
            $('.managerAddForm').trigger('reset');
            $('.restaurantName').html('select Restaurant');
        });

        var imagesUrl = '{!! URL::asset('/images/') !!}';
        $(document).ready(function() {
            // data table
            $('#managerTable').DataTable({
                "ordering": false,
            });
            // dropify 
            $('.dropify').dropify();

        });

        // $(document).ready(function() {
        //     $('#managerTable').DataTable({
        //         "ordering": false,
        //         initComplete: function() {
        //             this.api().columns().every(function() {
        //                 var column = this;
        //                 // alert(column);
        //                 var select = $(
        //                         '<select class="form-control filter_by_role"><option value="">Filter by Role</option></select>'
        //                         )
        //                     .appendTo($(column.footer()).empty())
        //                     .on('change', function() {
        //                         var val = $.fn.dataTable.util.escapeRegex(
        //                             $(this).val()
        //                         );

        //                         column
        //                             .search(val ? '^' + val + '$' : '', true, false)
        //                             .draw();
        //                     });

        //                 column.data().unique().sort().each(function(d, j) {
        //                     select.append('<option value="' + d + '">' + d +
        //                         '</option>')
        //                 });
        //             });
        //         }
        //     });

        //     $('#managerTable tfoot tr').prependTo('#managerTable thead');
        //     $('.loader').hide();

        // });

        // add form validation
        $(document).ready(function() {
            $(".managerAddForm").validate({
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
                    restaurant: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please insert manager name',
                    },
                    email: {
                        required: 'Please insert manager email',
                    },
                    restaurant: {
                        required: 'Please select a restaurant',
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

        $(document).on('submit', '.managerAddForm', function(event) {
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
                        var managerTable = $('#managerTable').DataTable();
                        var row = $('<tr>')
                            .append(`<td><img class="img-fluid" src="${imagesUrl}` + '/' +
                                `${response.data.photo !=null ? response.data.photo : 'default.png'}" style='width: 60px; height: 55px;'></td>`
                            )
                            .append(`<td>` + response.data.restaurant_name + `</td>`)
                            .append(`<td>` + response.data.name + `</td>`)
                            .append(`<td>` + response.data.sex + `</td>`)
                            .append(`<td>` + response.data.email + `</td>`)
                            .append(`<td>` + response.data.contact + `</td>`)
                            .append(`<td><button type='button' class='btn btn-outline-dark' onclick='viewManager(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-info' onclick='editManager(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>`)
                            // <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteManager(${response.data.id})">
                            //     <i class="mdi mdi-delete "></i>
                            // </button></td>
                        var manager_row = managerTable.row.add(row).draw().node();
                        $('#managerTable tbody').prepend(row);
                        $(manager_row).addClass('manager' + response.data.id + '');

                        $('.managerAddForm').trigger('reset');
                        if (response.data.message) {
                            $('#add').modal('hide');
                            toastMixin.fire({
                                icon: 'success',
                                animation: true,
                                title: "" + response.data.message + ""
                            });

                        }
                        $('.restaurant_select_box').empty();
                        $('.restaurant_select_box').append(
                            `<option value="" class="restaurantName"></option>`
                        );
                        $.each(response.data.restaurants, function(i, restaurant) {
                            $('.restaurant_select_box').append(
                                `<option value="${restaurant.restaurant_id}">${restaurant.name}</option>`
                            );
                        });


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

        //request end


        // view single 
        function viewManager(id) {
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
                        if (response.data.is_manager == 1) {
                            $('.view_role').html('Manager');
                        } else {
                            alert('sds');
                            $('.role_div').hide();
                        }
                        $('.delete_btn').attr('onclick', "deleteManager(" + id + ")");
                        $('#view_name').text(response.data.name);
                        $('#view_email').text(response.data.email);
                        $('#view_gender').text(response.data.sex ?? 'N/A');
                        $('#view_phone').text(response.data.contact ?? 'N/A');
                        $('#view_restaurant_name').text(response.data.restaurant ? response.data.restaurant
                            .name : 'N/A');


                        if (response.data.photo === null) {
                            $('#view_image').attr('src', '/images/default.png');
                        } else {
                            $('#view_image').attr('src', '/images/' + response.data.photo);
                        }



                        $('#viewModal').modal('show');

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
            }); //ajax end
        }




        // Update product
        //validation
        $(document).ready(function() {
            $(".updateManagerForm").validate({
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
                    phone: {
                        required: true,
                        digits: true,
                        maxlength: 50,
                    },
                    // profile_image: {
                    //     required: true,
                    // },
                },
                messages: {
                    name: {
                        required: 'Please insert manager name',
                    },
                    email: {
                        required: 'Please insert manager email',
                    },
                    phone: {
                        required: 'Please insert manager phone number',
                    },
                    // image: {
                    //     required: 'Please upload manager signature',
                    // },
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
                    label.insertAfter(element);
                },
            });
        });


        function editManager(id) {
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
                        // $('.restaurantName').html();
                        $('#edit_name').val(response.data.name)
                        $('#edit_email').val(response.data.email)
                        $('#hidden_id').val(response.data.id)
                        $('.restaurantName').html(response.data.restaurant ? response.data.restaurant
                            .name : '')
                        // $('#restaurant_id').val(response.data.restaurant ? response.data.restaurant
                        //     .name : '')
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
            $(document).off('submit', '.updateManagerForm');
            $(document).on('submit', '.updateManagerForm', function(event) {
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
                            $('.manager' + response.data.id).html(
                                `
                                <td><img class="img-fluid" src="${imagesUrl}` + '/' +
                                `${response.data.photo !=null ? response.data.photo : 'default.png'}" style='width: 60px; height: 55px;'></td>
                                <td>${response.data.restaurant_name}</td>
                                <td>${response.data.name}</td>
                                <td>${response.data.sex}</td>
                                <td>${response.data.email}</td>
                                <td>${response.data.contact}</td>
    
                                <td><button type='button' class='btn btn-outline-dark' onclick='viewManager(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-info' onclick='editManager(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>`                       
                            // <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteManager(${response.data.id})">
                            //     <i class="mdi mdi-delete "></i>
                            // </button></td>
                                
                            );
                            $('#edit_modal').modal('hide');
                            toastMixin.fire({
                                icon: 'success',
                                animation: true,
                                title: "" + response.data.message + ""
                            });
                            $('.updateManagerForm')[0].reset();

                            $('.restaurant_select_box').empty();
                            $('.restaurant_select_box').append(
                                `<option value="" class="restaurantName"></option>`
                            );
                            $.each(response.data.restaurants, function(i, restaurant) {
                                $('.restaurant_select_box').append(
                                    `<option value="${restaurant.restaurant_id}">${restaurant.name}</option>`
                                );
                            });
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

                        } else if (error.status == 404) {
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



        // delete 
        function deleteManager(id) {
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
                                $('#managerTable').DataTable().row('.manager' + response.data.id)
                                    .remove()
                                    .draw();
                                toastMixin.fire({
                                    icon: 'success',
                                    animation: true,
                                    title: "" + response.data.message + ""
                                });
                                $('#edit_modal').modal('show');
                                $('.restaurant_select_box').empty();
                                $('.restaurant_select_box').append(
                                    `<option value="" class="restaurantName"></option>`
                                );
                                $.each(response.data.restaurants, function(i, restaurant) {
                                    $('.restaurant_select_box').append(
                                        `<option value="${restaurant.restaurant_id}">${restaurant.name}</option>`
                                    );
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
