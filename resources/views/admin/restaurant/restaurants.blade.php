@extends('layouts.admin.master')
@section('page-header')
    Restaurants Section
@endsection
@section('pageCss')

    <style>
        .btn_disabled {
            pointer-events: none;
            cursor: not-allowed;
            box-shadow: none;
        }

        .mdi-plus {
            font-size: 25px;
            position: absolute;
            margin-left: -61px;
            cursor: pointer;
            border: 1px solid;
        }

        .close_icon_add_form {
            font-size: 25px;
            cursor: pointer;
            position: absolute;
            margin: 35px -10px;
            /* border: 1px solid #f24734; */
            color: #f24734;
        }

        .close_icon_edit_form {
            font-size: 25px;
            cursor: pointer;
            position: absolute;
            margin-top: 26px
        }

        .cross_icon {
            margin: -35px 10px;
        }

        .cross_icons {
            margin: -30px 10px;
        }

        /*.plus_icon{
                            padding: 0;
                        }*/
        .text-danger {
            margin-bottom: -20px;
        }

        .address {
            padding-top: 25px;
        }

        .work_asset_row {
            margin-right: 20px;
        }

        .map_url iframe {
            width: 100%;
            height: 350px;
        }

        .restaurant_image img {
            width: 100%;
        }
        .add_row_btn{
            padding:  3px 25px;
            margin-right:40px;
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
            background-color: #dc3545;
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
            background-color: #198754;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #018346;
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
                                    <h4 class="mt-0 header-title">All Restaurants</h4>
                                </div>
                                <button type="button" class="btn btn-outline-purple float-right waves-effect waves-light"
                                    name="button" id="addButton" data-toggle="modal" data-target="#add"> Add
                                    New
                                </button>
                            </div>

                            <span class="showError"></span>
                            <div class="table-responsive">
                                <table id="restaurantTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Asset</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Contact</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Active Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($restaurants))
                                            @foreach ($restaurants as $restaurant)
                                                <tr class="restaurant{{ $restaurant->restaurant_id }}">
                                                    <td>
                                                        @if ($restaurant->file_type == 'mp4' || $restaurant->file_type == 'mpeg' || $restaurant->file_type == 'webm' || $restaurant->file_type == '3gp' || $restaurant->file_type == 'avi')
                                                            <button class="play-btn"
                                                                onclick="playVideo('{{ asset('images/' . $restaurant->asset) }}')"><i
                                                                    class="fa fa-play play_icon"></i></button>

                                                        @else
                                                            <img class='img-fluid'
                                                                src="{{ asset('images/' . $restaurant->asset) }}"
                                                                alt="{{ $restaurant->name }}"
                                                                style='width: 60px; height: 55px;'>
                                                        @endif
                                                    </td>
                                                    <td>{{ $restaurant->name }}</td>
                                                    <td>{{ $restaurant->type }}</td>
                                                    <td>{{ $restaurant->formated_description }}...</td>
                                                    <td>{{ $restaurant->contact }}</td>
                                                    <td>{{ $restaurant->email }}</td>
                                                    <td>{{ $restaurant->address }}</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input class="is_active status{{ $restaurant->restaurant_id }}"
                                                                type="checkbox" {{ $restaurant->is_open == 1 ? 'checked' : '' }}
                                                                data-id="{{ $restaurant->restaurant_id }}">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>

                                                    <td>

                                                        <button type='button' class='btn btn-outline-dark'
                                                            onclick='viewRestaurant({{ $restaurant->restaurant_id }})'><i
                                                                class='fa fa-eye'></i></button>
                                                        <button type='button' class='btn btn-outline-info '
                                                            onclick='editRestaurant({{ $restaurant->restaurant_id }})'><i
                                                                class='mdi mdi-pencil'></i></button>
                                                        <button type='button' name='delete' class="btn btn-outline-danger "
                                                            onclick="deleteRestaurant({{ $restaurant->restaurant_id }})"><i
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
                    <h5 class="modal-title mt-0 text-center">Add New Restaurant</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="restaurantAddForm" method="POST" enctype="multipart/form-data"> @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Type name" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type</label>
                                    <input type="text" class="form-control" name="type" placeholder="Type" />
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input type="text" class="form-control" name="contact"
                                        placeholder="Type contact no" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Type email" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="" class="form-control" cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" id="" class="form-control" cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Select Delivery Locations</label>
                            <select name="location[]" class="form-control location-select-box" id="" multiple="multiple">
                                @if (!empty($locations))
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->delivery_location_id }}">{{ $location->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label id="location[]-error" class="error mt-2 text-danger" for="location[]"></label>
                        </div>
                        <div class="form-group">
                            <label>Logo</label>
                            <div class="custom-file">
                                <input type="file" name="logo" class="custom-file-input dropify"
                                    data-id="0" data-errors-position="outside"
                                    data-allowed-file-extensions='["jpg", "png"]' data-max-file-size="0.6M" data-height="80"
                                  >
                            </div>
                        </div>
                        <label for="">Photos</label>
                        <div class="row asset_row  asset_div0">
                          
                            {{-- <div class="col-md-5">
                                <div class="form-group">
                                    <select class="form-control asset error0" name="asset[][asset_type_id]" id="asset0"
                                        data-id="0">
                                        <option value="">Choose Asset Type</option>
                                        @foreach ($asset_types as $asset_type)
                                            <option value="{{ $asset_type->asset_type_id }}">{{ $asset_type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="error_msg0 text-danger"></span>
                                </div>
                            </div> --}}
                            <div class="col-md-11">
                                <div class="form-group ">
                                    <div class="custom-file">
                                        <input type="file" name="asset[][asset]" class="custom-file-input dropify" id="asset0"
                                            data-id="0" data-errors-position="outside"
                                            data-allowed-file-extensions='["jpg", "png", "svg","jpeg"]' data-max-file-size="0.6M"
                                            data-height="80">
                                    </div>
                                    <span class="error_msg0 text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class=" remove_row0" onclick="remove(0)"><i
                                        class="mdi mdi-delete close_icon_add_form"></i></div>
                            </div>
                        </div>
             
                        {{-- <div class="float-right" onclick="addRow()"><i class="mdi mdi-plus add_new_row_btn"></i>asdsad</div> --}}
                        <button class="btn btn-primary add_row_btn float-right" onclick="addRow()" type="button"><i class="fa fa-plus"></i>   Add</button>

                        <div class="form-group mt-5">
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
                    <h5 class="modal-title mt-0 text-center">Update Restaurant's Info</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="updaterestaurantForm" method="POST"> @csrf
                        <input type="hidden" name="hidden_id" id="hidden_id">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" id="edit_name"
                                        placeholder="Type name" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type</label>
                                    <input type="text" class="form-control" name="type" id="edit_type"
                                        placeholder="Type" />
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact</label>
                                    <input type="text" class="form-control" name="contact" id="edit_contact"
                                        placeholder="Type contact no" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" id="edit_email"
                                        placeholder="Type email" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" id="edit_description" cols="30"
                                rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control" id="edit_address" cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Select Delivery Locations</label>
                            <select name="location[]" class="form-control location-select-box" id="edit_location_select_box" multiple="multiple">
                                @if (!empty($locations))
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->delivery_location_id }}">{{ $location->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label id="location[]-error" class="error mt-2 text-danger" for="location[]"></label>
                        </div>
                        <div class="form-group">
                            <label>Logo</label>
                            <div class="custom-file edit_logo">
                                <input type="file" name="logo" id="edit_logo" class="custom-file-input dropify"
                                    data-id="0" data-errors-position="outside"
                                    data-allowed-file-extensions='["jpg", "png", "svg","jpeg"]' data-max-file-size="0.6M" data-height="80"
                                  >
                            </div>
                        </div>
                        <label for="">Photos</label>
                        <span id="append_restaurant_assets"></span>
                        {{-- <div class="float-right" onclick="addRowEdit()"><i class="mdi mdi-plus add_new_row_btn"></i>
                        </div> --}}
                        <button class="btn btn-primary add_row_btn float-right" onclick="addRowEdit()" type="button"><i class="fa fa-plus"></i>   Add</button>


                        <div class="form-group mt-5">
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
                    <h5 class="modal-title mt-0 text-center">Restaurant Details</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-row restaurant_image">
                        {{-- <div class="col-xl-6 col-md-12"> --}}
                            <div class="form-group">
                                <img src="" alt="image" id="view_image">
                            </div>
                        {{-- </div> --}}
                    </div>

                    <div class="ms-form-group">
                        <p>
                            <strong>Name:</strong> <span id="view_name"></span>
                        </p>
                        <p>
                            <strong>Type:</strong> <span id="view_type"></span>
                        </p>
                        <p>
                            <strong>Email:</strong> <span id="view_email"></span>
                        </p>
                        <p>
                            <strong>Contact:</strong> <span id="view_contact"></span>
                        </p>
                        <p>
                            <strong>Address:</strong> <span id="view_address"></span>
                        </p>
                        <p>
                            <strong>Description:</strong> <span id="view_description"></span>
                        </p>
                        <p>
                            <strong>Delivery Locations:</strong> <span id="view_location"></span>
                        </p>

                    </div>

                    {{-- <div class="row mt-3">
                        <div class="col-xl-6 col-md-6">
                            <div class="ms-form-group">
                                <label for="name"><strong>Name:</strong></label>
                                <p id="view_name"></p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="ms-form-group">
                                <label for="name"><strong>Type:</strong></label>
                                <p id="view_type"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="ms-form-group">
                                <label for="name"><strong>Email:</strong></label>
                                <p id="view_email"></p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="ms-form-group">
                                <label for="name"><strong>Contact:</strong></label>
                                <p id="view_contact"></p>
                            </div>
                        </div>
                    </div>
                    <div class="ms-form-group">
                        <label for="name"><strong>Address:</strong></label>
                        <p id="view_address"></p>
                    </div>
                    <div class="ms-form-group">
                        <label for="name"><strong>Description:</strong></label>
                        <p id="view_description"></p>
                    </div> --}}


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

    <script src="{{ asset('backend/assets/js/add_row.js') }}"></script>
    <script type='text/javascript'>
        var config = {
            routes: {
                add: "{!! route('restaurant.store') !!}",
                edit: "{!! route('restaurant.edit') !!}",
                view: "{!! route('restaurant.show') !!}",
                update: "{!! route('restaurant.update') !!}",
                delete: "{!! route('restaurant.delete') !!}",
                delete_asset: "{!! route('restaurant.asset.delete') !!}",
                updateStatus: "{!! route('restaurant.status.update') !!}",
            }
        };

        $('#addButton').on('click', function() {
            $('.dropify-preview').hide();
            $('.restaurantAddForm').trigger('reset');
            $('.location-select-box').val(null).trigger('change');
        });

        var imagesUrl = '{!! URL::asset('/images/') !!}/';
        $(document).ready(function() {
            $('#restaurantTable').DataTable({
                "ordering": false,
            });
            $('.dropify').dropify();

        });




        $(document).ready(function() {
            // add form validation
            $(".restaurantAddForm").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true,
                        maxlength: 100,
                    },
                    'asset[][asset_type_id]': {
                            required: true
                            },
                    'asset[][asset]': {
                            required: true
                            },
                    "location[]": "required",
                    type: {
                        required: true,
                        maxlength: 100,
                    },
                    contact: {
                        required: true,
                        maxlength: 100,
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 100,
                    },
                    description: {
                        required: true,
                        maxlength: 10000,
                    },
                    address: {
                        required: true,
                        maxlength: 10000,
                    },
                    logo: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please insert restaurant name',
                    },
                    "location[]": "Please select a location",
                    type: {
                        required: 'Please insert restaurant type',
                    },
                    contact: {
                        required: 'Please insert restaurant contact number',
                    },
                    email: {
                        required: 'Please insert restaurant email',
                        email: 'Email must be valid',
                    },
                    description: {
                        required: 'Please insert restaurant description',
                    },
                    address: {
                        required: 'Please insert restaurant address',
                    },
                    logo: {
                        required: 'Please upload restaurant logo',
                    },
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
                    label.insertAfter(element);
                },
            });
            // update form validation
            $(".updaterestaurantForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 100,
                    },
                    type: {
                        required: true,
                        maxlength: 100,
                    },
                    contact: {
                        required: true,
                        maxlength: 100,
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 100,
                    },
                    description: {
                        required: true,
                        maxlength: 10000,
                    },
                    address: {
                        required: true,
                        maxlength: 10000,
                    },

                },
                messages: {
                    name: {
                        required: 'Please insert restaurant name',
                    },
                    type: {
                        required: 'Please insert restaurant type',
                    },
                    contact: {
                        required: 'Please insert restaurant contact number',
                    },
                    email: {
                        required: 'Please insert restaurant email',
                        email: 'Email must be valid',
                    },
                    description: {
                        required: 'Please insert restaurant description',
                    },
                    address: {
                        required: 'Please insert restaurant address',
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

        $(document).on('submit', '.restaurantAddForm', function(event) {
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
                        if (response.data.file_type == "mp4" || response.data.file_type == "mpeg" ||
                            response.data.file_type == "webm" || response.data.file_type == "3gp" ||
                            response.data.file_type == "avi") {
                            var img = `<button class="play-btn" onclick='playVideo("${imagesUrl}/${response.data.image}")'>
                                           <i class="fas fa-play play_icon"></i>
                                       </button>`;
                        } else {
                            var img = "<img class='img-fluid' src='" + imagesUrl + '/' + response.data
                                .image + "'alt=" + response.data.name +
                                " style='width: 60px; height: 55px;'>"
                        }
                        var restaurantTable = $('#restaurantTable').DataTable();
                        var row = $('<tr>')
                            .append(`<td>` + img + `</td>`)
                            .append(`<td>` + response.data.name + `</td>`)
                            .append(`<td>` + response.data.type + `</td>`)
                            .append(`<td>` + response.data.description + `...</td>`)
                            .append(`<td>` + response.data.contact + `</td>`)
                            .append(`<td>` + response.data.email + `</td>`)
                            .append(`<td>` + response.data.address + `</td>`)
                            .append(`<td><label class="switch">
                                            <input class="is_active status${ response.data.id}"type="checkbox"
                                                ${response.data.is_available == 1 ? 'checked' : ''}data-id="${response.data.id}">
                                                     <span class="slider round"></span>
                                         </label></td>`)
                            .append(`<td><button type='button' class='btn btn-outline-dark' onclick='viewRestaurant(${response.data.id})'>
                                            <i class='fa fa-eye'></i>
                                        </button>
                                        <button type='button' class='btn btn-outline-info' onclick='editRestaurant(${response.data.id})'>
                                            <i class='mdi mdi-pencil'></i>
                                        </button>  <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteRestaurant(${response.data.id})">
                                            <i class="mdi mdi-delete "></i>
                                        </button></td>
                           
                         `)



                        var restaurant_row = restaurantTable.row.add(row).draw().node();
                        $('#restaurantTable tbody').prepend(row);
                        $(restaurant_row).addClass('restaurant' + response.data.id + '');
                        $('.restaurantAddForm').trigger('reset');
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
        function viewRestaurant(id) {
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
                        $('#view_type').text(response.data.type);
                        $('#view_email').text(response.data.email);
                        $('#view_contact').text(response.data.contact);
                        $('#view_address').text(response.data.address);
                        $('#view_description').text(response.data.description);
                        $('#view_location').empty();
                        $.each(response.data.delivery_locations, function(i, val) {
                            $('#view_location').append(
                                `<span id="view_location">${val.name}, </span>`
                            )
                        });

                        $('.restaurant_image').empty();
                        $.each(response.data.assets, function(key, val) {
                            var extension = val.pivot.asset.substr((val.pivot.asset.lastIndexOf('.') +
                                1));
                            if (extension == "mp4" || extension == "mpeg" || extension == "webm" ||
                                extension == "3gp" || extension == "avi") {
                                var img = `<video  width='360' height="240" controls>
                                                <source src="${imagesUrl}/${val.pivot.asset}" type="video/mp4">
                                            </video>`;

                            } else {
                                var img =
                                    `<img src="${imagesUrl+'/'+val.pivot.asset}" alt="image" id="view_image">`;
                            }


                            $(".restaurant_image").append(
                                `<div class="col-xl-6 col-md-12">
                                        <div class="ms-form-group">
                                            ${img}
                                        </div>
                                    </div>`

                            );
                        });
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

        function editRestaurant(id) {
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
                        $('#edit_name').val(response.data.name)
                        $('#edit_type').val(response.data.type)
                        $('#edit_contact').val(response.data.contact)
                        $('#edit_email').val(response.data.email)
                        $('#edit_address').val(response.data.address)
                        $('#edit_description').val(response.data.description)
                        $('#hidden_id').val(response.data.restaurant_id)

                        var locations_id=[];
                         $.each(response.data.delivery_locations, function(key,value){
                            locations_id.push(value.delivery_location_id)
                          });  

                        $('#edit_location_select_box').val(locations_id);
                        $('#edit_location_select_box').trigger('change');

                        if (response.data.logo) {
                            var photo = imagesUrl + response.data.logo;
                            $("#edit_logo").attr("data-height", 150);
                            $("#edit_logo").attr("data-min-width", 450);
                            $("#edit_logo").attr("data-default-file", photo);
                            $('.edit_logo').find(".dropify-wrapper").removeClass(
                                "dropify-wrapper").addClass(
                                "dropify-wrapper has-preview");
                            $('.edit_logo').find(".dropify-preview").css('display', 'block');
                            $('.edit_logo').find('.dropify-render').html('').html('<img src=" ' +
                                photo +
                                '">')
                        } else {
                            $(".dropify-preview .dropify-render img").attr("src", "");
                            $('.dropify-preview').hide();
                        }
                        $('#append_restaurant_assets').empty();
                        $.each(response.data.assets, function(key, value) {
                            $('#append_restaurant_assets').append(
                                ` <div class="row area_row_edit  asset_div_edit${key}">                         
                                        <div class="col-md-11"> 
                                            <div class="form-group">
                                                <div class="custom-file url${key}">
                                                    
                                                    <input type="file" name="asset[${key}][asset]" id="urla${key}"
                                                                class="custom-file-input linkImage link_img${key}"
                                                                data-height="80" data-errors-position="outside"
                                                                data-allowed-file-extensions='["jpg","png","webp","gif","mp4","mpeg","webm","3gp","avi"]'>
                                                          
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="col-md-1">
                                            <div class=" remove_row${key}" onclick="remove_row_edit(${key},${value.id})" data-id="${value.id}"><i class="mdi mdi-delete close_icon_add_form"></i></div>
                                        </div> 
                                    </div>`
                            );
                            if (value.pivot.asset) {
                                var img_url = imagesUrl + value.pivot.asset;
                                // alert(img_url);

                                $('.link_img' + key).attr("data-height", 80);
                                $('.link_img' + key).attr("data-default-file", img_url);

                                $('.link_image' + key).find(".dropify-wrapper").removeClass(
                                    "dropify-wrapper").addClass("dropify-wrapper has-preview");
                                $('.link_image' + key).find(".dropify-preview").css('display', 'block');
                                $('.link_image' + key).find('.dropify-render').html('').html(
                                    '<img src=" ' + img_url + '" style="max-height: 25px;">')
                            } else {
                                $('.link_image' + key).find(".dropify-preview .dropify-render img")
                                    .attr("src", "");
                            }
                            $('.link_img' + key).dropify();
                        })


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

            $(document).off('submit', '.updaterestaurantForm');
            $(document).on('submit', '.updaterestaurantForm', function(event) {
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
                            if (response.data.file_type == "mp4" || response.data.file_type == "mpeg" ||
                                response.data.file_type == "webm" || response.data.file_type == "3gp" ||
                                response.data.file_type == "avi") {
                                var img = `<button class="play-btn" onclick='playVideo("${imagesUrl}/${response.data.image}")'>
                                           <i class="fas fa-play play_icon"></i>
                                       </button>`;
                            } else {
                                var img = "<img class='img-fluid' src='" + imagesUrl + response.data
                                    .image + "'alt=" + response.data.name +
                                    " style='width: 60px; height: 55px;'>"
                            }
                            $('.restaurant' + response.data.id).html(
                                `
                                <td>${img}</td>
                                <td>${response.data.name}</td>
                                <td>${response.data.type}</td>
                                <td>${response.data.description}...</td>
                                <td>${response.data.contact}</td>
                                <td>${response.data.email}</td>
                                <td>${response.data.address}</td>   
                                <td>
                                    <label class="switch">
                                        <input class="is_available status${ response.data.id}"type="checkbox"
                                            ${(response.data.is_open == 1 ) ? 'checked' : ' '} data-id="${response.data.id}">
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <td><button type='button' class='btn btn-outline-dark' onclick='viewRestaurant(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-info' onclick='editRestaurant(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>
                            <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteRestaurant(${response.data.id})">
                                <i class="mdi mdi-delete "></i>
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
                                $('.updaterestaurantForm')[0].reset();
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


                        }else if (error.status == 422) {
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
        function deleteRestaurant(id) {
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
                                $('#restaurantTable').DataTable().row('.restaurant' + response.data
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
        var i = 0;

        function addRow() {
            var asset = $(".asset_row")
                .find("#asset" + i)
                .val();
            if (asset === "") {
                $(".error_msg" + i)
                    .addClass("mt-1")
                    .text("Please upload photo");
                $(".error_msg" + i).show();

            } else {
                ++i;

                var new_i = i - 1;
                $(".error_msg" + new_i).hide();
                alert('sds');
                $(".asset_row:last")
                    .after(` <div class="row asset_row test_row asset_div${i}">                         
                        <div class="col-md-11">
                        <div class="form-group ">
                            <div class="custom-file">
                                <input type="file" name="asset[][asset]" class="custom-file-input dropify${i}" data-id="${i}" id="asset${i}"
                                    data-errors-position="outside" data-allowed-file-extensions='["jpg", "png"]'
                                    data-max-file-size="0.6M" data-height="80">
                            </div>
                            <span class="error_msg${i} text-danger"></span>
                        </div>
                    </div> 

                        <div class="col-md-1">
                            <div class="remove_row${i}" onclick="remove(${i})"><i class="mdi mdi-delete close_icon_add_form"></i></div>
                        </div> 
                    </div>`);
                $('.dropify' + i).dropify();
            }
        }

        function remove(id) {
            var length = $('.asset_row').length;
            if (length === 1) {
                $(".asset_div" + id).empty();
            } else {
                $(".asset_div" + id).remove();
            }

        }

        // edit modal add row start 
        var i = 0;

        function addRowEdit() {
            var area_edit = $(".area_row_edit")
                .find("#area_new_edit" + i)
                .val();

            var length = $('.area_row_edit').length;
            i = length - 1;
            if (area_edit === "") {
                $(".edit_row_error_msg" + i)
                    .addClass("mt-1")
                    .text("Please upload photo");
                $(".edit_row_error_msg" + i).show();

            } else {
                ++i;

                var new_i = i - 1;
                $(".edit_row_error_msg" + new_i).hide();
                $(".area_row_edit:last")
                    .after(` <div class="row area_row_edit  asset_div_edit${i}">                         

                        <div class="col-md-11">
                        <div class="form-group ">
                            <div class="custom-file">
                                <input type="file" name="new_asset[${i}][asset]" class="custom-file-input dropify${i}" data-id="${i}" id="area_new_edit${i}"
                                    data-errors-position="outside" data-allowed-file-extensions='["jpg", "png"]'
                                    data-max-file-size="0.6M" data-height="80">
                            </div>
                            <span class="edit_row_error_msg${i} text-danger"></span>
                        </div>
                    </div> 

                        <div class="col-md-1">
                            <div class="remove_row${i}" onclick="remove_edit_row(${i})"><i class="mdi mdi-delete close_icon_add_form"></i></div>
                        </div> 
                            </div>`);
                $('.dropify' + i).dropify();
            }

        }

        function remove_edit_row(id) {
            var length = $('.area_row_edit').length;
            // alert(length)
            if (length === 1) {
                $(".asset_div_edit" + id).empty();
            } else {
                $(".asset_div_edit" + id).remove();
            }

        }

        function remove_row_edit(id, data_id) {
            var length = $('.area_row_edit').length;
            if (length === 1) {
                $(".asset_div_edit" + id).empty();
            } else {
                $.ajax({
                url: config.routes.delete_asset,
                method: "POST",
                data: {
                    id: data_id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        $(".asset_div_edit" + id).remove();

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

        }

              // active status change function
        $(document.body).on('click', '.is_active', function() {
            var id = $(this).attr('data-id');
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
                        url: config.routes.updateStatus,
                        method: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.success == true) {
                                toastMixin.fire({
                                    icon: 'success',
                                    animation: true,
                                    title: "" + response.data.message + ""
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

                    }); //ajax end
                } else {
                    if ($('.status' + id + "").prop("checked") == true) {
                        $('.status' + id + "").prop('checked', false);
                    } else {
                        $('.status' + id + "").prop('checked', true);
                    }
                }
            })
        });  
    </script>
@endsection
