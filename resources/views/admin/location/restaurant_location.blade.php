@extends('layouts.admin.master')
@section('page-header')
    All Restaurant Locations
@endsection
@section('pageCss')
    <style>

    </style>
@endsection
@section('content')
    <div class="preloader"></div>
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-4">
                                <div class="ms-header-text">
                                    <h4 class="mt-0 header-title"> All Restaurant Locations</h4>
                                </div>
                                <button type="button" class="btn btn-outline-purple float-right waves-effect waves-light"
                                    name="button" id="addButton" data-toggle="modal" data-target="#add"> Add
                                    New
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="locationTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Restaurant Name</th>
                                            <th>Location Name</th>
                                            <th>Delivery Charge</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($restaurant_loations))
                                            @foreach ($restaurant_loations as $restaurant_loation)
                                                <tr class="location{{ $restaurant_loation->id }}">
                                                    <td>{{ $restaurant_loation->restaurant->name }}</td>
                                                    <td>{{ $restaurant_loation->location->name }}</td>
                                                    <td>{{ currency_format($restaurant_loation->delivery_fee)}}</td>
                                                    <td>
                                                        <button type='button' class='btn btn-outline-info'
                                                            onclick='editLocation({{ $restaurant_loation->id }})'>
                                                            <i class="mdi mdi-pencil "></i>
                                                        </button>

                                                        <button type='button' name='delete' class="btn btn-outline-danger "
                                                            onclick="deletelocation({{ $restaurant_loation->id }})"><i
                                                                class="mdi mdi-delete "></i></button>
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


    <!-- Add  Modal -->
    <div class="modal fade bs-example-modal-center" id="add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-block">
                    <h5 class="modal-title mt-0 text-center">Add a new location</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="locationAddForm" method="POST"> @csrf
                        <div class="form-group">
                            <label for="">Select a Restaurant </label>
                            <select name="restaurant_id" class="form-control">
                                <option value="">Select a Restaurant</option>
                                @if (!empty($restaurants))
                                    @foreach ($restaurants as $restaurant)
                                        <option value="{{ $restaurant->restaurant_id }}">{{ $restaurant->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Select a location </label>
                            <select name="location_id" class="form-control">
                                <option value="">Select a location</option>
                                @if (!empty($locations))
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->delivery_location_id }}">{{ $location->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Delivery Fee</label>
                            <input type="text" class="form-control" name="delivery_fee">
                        </div>
                        <div class="form-group mt-2">
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
                    <h5 class="modal-title mt-0 text-center">Update a location</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="updateHeroSectionForm" method="POST"> @csrf
                        <input type="hidden" name="hidden_id" id="hidden_id">

                        <div class="form-group">
                            <label for="">Select a Restaurant </label>
                            <select name="restaurant_id" class="form-control" id="edit_restaurant">
                                <option value="">Select a Restaurant</option>
                                @if (!empty($restaurants))
                                    @foreach ($restaurants as $restaurant)
                                        <option value="{{ $restaurant->restaurant_id }}">{{ $restaurant->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Select a location </label>
                            <select name="location_id" class="form-control" id="edit_location">
                                <option value="">Select a location</option>
                                @if (!empty($locations))
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->delivery_location_id }}">{{ $location->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Delivery Fee</label>
                            <input type="text" class="form-control" name="delivery_fee" id="edit_delivery">
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


    @include('layouts.admin.restaurant_add_modal')
@endsection
@section('pageScripts')
    <script type='text/javascript'>
        var config = {
            routes: {
                add: "{!! route('restaurant.location.store') !!}",
                edit: "{!! route('restaurant.location.edit', ':id') !!}",
                update: "{!! route('restaurant.location.update') !!}",
                delete: "{!! route('restaurant.location.destroy') !!}",
            }
        };

        $('#addButton').on('click', function() {
            $('.locationAddForm').trigger('reset');
        });

        $(document).ready(function() {
            $('#locationTable').DataTable({
                "ordering": false,
            });
            $('.items_li').addClass('sub-nav-active');
            $('.items_li a').siblings("ul").toggle().removeClass("d-none");
            $('.items_li a')
                .children("span")
                .children("span")
                .children(".mdi")
                .css("transform", "rotate(0deg)");
            $('.restaurant_li').addClass('nav-active');
        });




        $(document).ready(function() {
            // add form validation
            $(".locationAddForm").validate({
                rules: {
                    restaurant: {
                        required: true,
                    },
                    location: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please select a restaurant',
                    },
                    location: {
                        required: 'Please select a location',
                    },
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
                    label.insertAfter(element);
                },
            });
            // update form validation
            $(".updateHeroSectionForm").validate({
                rules: {
                    restaurant: {
                        required: true,
                    },
                    location: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please select a restaurant',
                    },
                    location: {
                        required: 'Please select a location',
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

        $(document).on('submit', '.locationAddForm', function(event) {
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
                        var locationTable = $('#locationTable').DataTable();
                        var row = $('<tr>')
                            .append(`<td>` + response.data.restaurant.name + `</td>`)
                            .append(`<td>` + response.data.location.name + `</td>`)
                            .append(`<td>` + response.data.deliveryCharge + `</td>`)
                            .append(`<td>
                            <button type='button' class='btn btn-outline-info' onclick='editLocation(${response.data.id})'>
                                    <i class="mdi mdi-pencil"></i>
                             </button>
                            <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deletelocation(${response.data.id})">
                                <i class="mdi mdi-delete "></i>
                            </button></td>`);


                        var location_row = locationTable.row.add(row).draw().node();
                        $('#locationTable tbody').prepend(row);
                        $(location_row).addClass('location' + response.data.id + '');
                        $('.locationAddForm').trigger('reset');
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

        function editLocation(id) {
            var url = config.routes.edit.replace(':id', id);
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        $('#edit_delivery').val(response.data.delivery_fee)
                        $('#edit_restaurant').val(response.data.restaurant_id)
                        $('#edit_location').val(response.data.delivery_location_id)
                        $('#hidden_id').val(response.data.id)
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

            $(document).off('submit', '.updateHeroSectionForm');
            $(document).on('submit', '.updateHeroSectionForm', function(event) {
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
                            console.log(response.data.location.name);
                            $('.location' + response.data.id).html(
                                `
                                <td>${response.data.restaurant.name}</td>
                                <td>${response.data.location.name}</td>
                                <td>${response.data.deliveryCharge}</td>
                                <td>
                            <button type='button' class='btn btn-outline-info' onclick='editLocation(${response.data.id})'>
                                    <i class="mdi mdi-pencil"></i>
                             </button>
                            <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deletelocation(${response.data.id})">
                                <i class="mdi mdi-delete "></i>
                            </button></td>
                                `
                            );
                            if (response.data.message) {
                                $('#edit_modal').modal('hide');
                                toastMixin.fire({
                                    icon: 'success',
                                    animation: true,
                                    title: "" + response.data.message + ""
                                });
                                $('.updateHeroSectionForm')[0].reset();
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


                        } else if (error.status == 422) {
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

        }


        // delete slider
        function deletelocation(id) {
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
                                $('#locationTable').DataTable().row('.location' + response.data
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
