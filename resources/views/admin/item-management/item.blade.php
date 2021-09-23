@extends('layouts.admin.master')
@section('page-header')
    Items
@endsection
@section('restaurant_list')
@include('layouts.admin.restaurant_drop-down')
@endsection
@section('pageCss')
    <style>
        .view-modal-footer {
            display: initial !important;
        }

        .view-modal p {
            line-height: 2;
        }

        .modal-footer>:not(:first-child) {
            margin-left: 0;
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
                                    <h4 class="mt-0 header-title">All Items</h4>
                                </div>

                                <button type="button" class="btn btn-outline-purple float-right waves-effect waves-light"
                                    name="button" id="addButton" data-toggle="modal" data-target="#add"> Add
                                    New
                                </button>



                            </div>

                            <span class="showError"></span>
                            <div class="table-responsive">
                                <table id="itemTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Category Name</th>
                                            <th>Photo</th>
                                            <th>Item Name</th>
                                            <th>Unit Price</th>
                                            <th>Show to Customers</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($items))
                                            @foreach ($items as $item)
                                                <tr class="item{{ $item->item_id }}">
                                                    <td>{{ $item->category->name ?? 'N/A' }}</td>
                                                    <td>
                                                        <img class='img-fluid' src="{{ asset('images/' . $item->asset) }}"
                                                            alt="{{ $item->name }}" style='width: 60px; height: 55px;'>
                                                    </td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->price }}</td>

                                                    <td><label class="switch">
                                                            <input class="is_available status{{ $item->item_id }}"
                                                                type="checkbox"
                                                                {{ $item->is_available == 1 ? 'checked' : '' }}
                                                                data-id="{{ $item->item_id }}">
                                                            <span class="slider round"></span>
                                                        </label></td>

                                                    <td>

                                                        <button type='button' class='btn btn-outline-dark'
                                                            onclick='viewItem({{ $item->item_id }})'><i
                                                                class='fa fa-eye'></i></button>
                                                        <button type='button' class='btn btn-outline-info '
                                                            onclick='editItem({{ $item->item_id }})'><i
                                                                class='mdi mdi-pencil'></i></button>

                                                        <button type='button' name='delete' class="btn btn-outline-danger "
                                                            onclick="deleteItem({{ $item->item_id }})"><i
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
                    <h5 class="modal-title mt-0 text-center">Add a new Item</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="itemAddForm" method="POST"> @csrf
                        <input type="hidden" name="restaurant_id" value="{{ $restaurant->restaurant_id }}"
                            class="restaurant_id">
                        <div class="form-group">
                            <label>Item Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Type name" />
                        </div>
                        <div class="form-group">
                            <label>Select Category</label>
                            <select name="category_id" class="form-control category_select_box">
                                <option value=""></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Item Description</label>
                            <textarea name="description" id="" class="form-control" cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Unit Price</label>
                            <input type="text" class="form-control" name="price" />
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Taste</label>
                                    <input type="text" class="form-control" name="taste" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Volume/Amount</label>
                                    <input type="text" class="form-control" name="volume" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="">Item Photo</label>
                            <div class="custom-file">
                                <input type="file" name="photo" class="custom-file-input dropify"
                                    data-errors-position="outside" data-allowed-file-extensions='["jpg", "png","jpeg"]'
                                    data-max-file-size="0.6M" data-height="80">
                            </div>
                        </div>
                        <div class="form-group">
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
                    <h5 class="modal-title mt-0 text-center">Update a Item</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="updateIteform" method="POST"> @csrf
                        <input type="hidden" name="hidden_id" id="hidden_id">
                        <input type="hidden" name="restaurant_id" class="restaurant_id"
                            value="{{ $restaurant->restaurant_id }}">

                        <div class="form-group">
                            <label>Item Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" />
                        </div>
                        <div class="form-group">
                            <label>Select Category</label>
                            <select name="category_id" id="edit_category_id" class="form-control category_select_box">
                                <option value=""></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Item Description</label>
                            <textarea name="description" id="edit_description" class="form-control" cols="30"
                                rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Unit Price</label>
                            <input type="text" class="form-control" name="price" id="edit_price" />
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Taste</label>
                                    <input type="text" class="form-control" name="taste" id="edit_taste" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Volume/Amount</label>
                                    <input type="text" class="form-control" name="volume" id="edit_volume" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="">Item Photo</label>
                            <div class="custom-file edit_photo">
                                <input type="file" name="photo" class="custom-file-input dropify" id="edit_photo"
                                    data-errors-position="outside" data-allowed-file-extensions='["jpg", "png","jpeg"]'
                                    data-max-file-size="0.6M" data-height="80">
                            </div>
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
                    <h5 class="modal-title mt-0 text-center">Item Details</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group view-modal">
                            <p class="pb-3">
                                <strong>Item Name:</strong> <span id="view_name"></span><br>
                                <strong>Category:</strong> <span id="view_category"></span><br>
                                <strong>Item Description:</strong> <span id="view_description"></span><br>
                                <strong>Unit Price:</strong> <span id="view_price"></span><br>
                                <strong>Taste :</strong> <span id="view_taste"></span><br>
                                <strong>Volume/Amount :</strong> <span id="view_volume"></span><br>
                                <strong>Item Photo :</strong><br>
                                <img class="mt-2" src="" id="view_image" style="width: 100%;">
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer view-modal-footer">
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
                add: "{!! route('item.store') !!}",
                edit: "{!! route('item.edit') !!}",
                view: "{!! route('item.show') !!}",
                update: "{!! route('item.update') !!}",
                delete: "{!! route('item.delete') !!}",
                getItems: "{!! route('item.restaurant') !!}",
                updateAvailableStatus: "{!! route('item.available.status.update') !!}",
            }
        };

        $('#addButton').on('click', function() {
            $('.itemAddForm').trigger('reset');
            $('.dropify-preview').hide();
        });

        $(document).ready(function() {

            $('#itemTable').DataTable({
                "ordering": false,
            });
            $('.dropify').dropify({
                error: {
                    'fileSize': 'The file size is too big ( 600KB  max).',
                }
            });
        });




        $(document).ready(function() {
            // add form validation
            $(".itemAddForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 100,
                    },
                    category_id: {
                        required: true,
                    },
                    description: {
                        required: true,
                        maxlength: 10000,
                    },
                    price: {
                        required: true,
                        maxlength: 50,
                        digits: true,
                    },
                    taste: {
                        required: true,
                        maxlength: 255,
                    },
                    volume: {
                        required: true,
                        maxlength: 255,
                    },
                    photo: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please insert item name',
                    },
                    description: {
                        required: 'Please insert item description',
                    },
                    price: {
                        required: 'Please insert item price',
                    },
                    taste: {
                        required: 'Please insert item taste',
                    },
                    taste: {
                        required: 'Please insert item taste',
                    },
                    taste: {
                        required: 'Please insert item volume',
                    },
                    category_id: {
                        required: 'Please select a category',
                    },
                    photo: {
                        required: 'Please upload a photo',
                    },
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
                    label.insertAfter(element);
                },
            });
            // update form validation
            $(".updateIteform").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 100,
                    },
                    category_id: {
                        required: true,
                    },
                    description: {
                        required: true,
                        maxlength: 10000,
                    },
                    price: {
                        required: true,
                        maxlength: 50,
                        digits: true,
                    },
                    taste: {
                        required: true,
                        maxlength: 255,
                    },
                    volume: {
                        required: true,
                        maxlength: 255,
                    },
                },
                messages: {
                    name: {
                        required: 'Please insert item name',
                    },
                    description: {
                        required: 'Please insert item description',
                    },
                    price: {
                        required: 'Please insert item price',
                    },
                    taste: {
                        required: 'Please insert item taste',
                    },
                    taste: {
                        required: 'Please insert item taste',
                    },
                    taste: {
                        required: 'Please insert item volume',
                    },
                    category_id: {
                        required: 'Please select a category',
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
        var imagesUrl = '{!! URL::asset('/images/') !!}/';
        $(document).on('submit', '.itemAddForm', function(event) {
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
                        var itemTable = $('#itemTable').DataTable();
                        var row = $('<tr>')
                            .append(`<td>` + response.data.category + `</td>`)
                            .append(`<td><img class="img-fluid" src="${imagesUrl}` +
                                `${response.data.image}" style='width: 60px; height: 55px;'></td>`)
                            .append(`<td>` + response.data.name + `</td>`)
                            .append(`<td>` + response.data.price + `</td>`)
                            .append(`<td><label class="switch">
                                            <input class="is_available status${ response.data.id}"type="checkbox"
                                                ${response.data.is_available == 1 ? 'checked' : ''}data-id="${response.data.id}">
                                                     <span class="slider round"></span>
                                         </label></td>`)

                            .append(`<td><button type='button' class='btn btn-outline-dark' onclick='viewItem(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-info' onclick='editItem(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>
                            <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteItem(${response.data.id})">
                                <i class="mdi mdi-delete "></i>
                            </button></td>`)


                        var category_row = itemTable.row.add(row).draw().node();
                        $('#itemTable tbody').prepend(row);
                        $(category_row).addClass('item' + response.data.id + '');
                        $('.itemAddForm').trigger('reset');
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
        function viewItem(id) {
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
                        $('#view_description').text(response.data.description);
                        $('#view_category').text(response.data.category.name);
                        $('#view_price').text(response.data.price);
                        $('#view_volume').text(response.data.volume);
                        $('#view_taste').text(response.data.taste);
                        $('#view_photo').text(response.data.photo);
                        if (response.data.image != null) {
                            $('#view_image').attr('src', imagesUrl + response.data.image);
                        }
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

        function editItem(id) {
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
                        $('#edit_description').val(response.data.description)
                        $('#edit_category_id').val(response.data.category.category_id)
                        $('#edit_taste').val(response.data.taste)
                        $('#edit_volume').val(response.data.volume)
                        $('#edit_price').val(response.data.price)
                        $('#hidden_id').val(response.data.item_id)

                        if (response.data.image) {
                            var photo = imagesUrl + response.data.image;
                            $("#edit_photo").attr("data-height", 150);
                            $("#edit_photo").attr("data-min-width", 450);
                            $("#edit_photo").attr("data-default-file", photo);
                            $('.edit_photo').find(".dropify-wrapper").removeClass(
                                "dropify-wrapper").addClass(
                                "dropify-wrapper has-preview");
                            $('.edit_photo').find(".dropify-preview").css('display', 'block');
                            $('.edit_photo').find('.dropify-render').html('').html('<img src=" ' +
                                photo +
                                '">')
                        } else {
                            $(".dropify-preview .dropify-render img").attr("src", "");
                        }

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

            $(document).off('submit', '.updateIteform');
            $(document).on('submit', '.updateIteform', function(event) {
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
                            $('.item' + response.data.id).html(
                                `
                                <td>${response.data.category}</td>
                                <td><img class="img-fluid" src="${imagesUrl}` +
                                `${response.data.image}" style='width: 60px; height: 55px;'></td>
                                <td>${response.data.name}</td>
                                <td>${response.data.price}</td>
                                <td>
                                    <label class="switch">
                                            <input class="is_available status${ response.data.id}"type="checkbox"
                                                ${(response.data.is_available == 1 ) ? 'checked' : ' '} data-id="${response.data.id}">
                                                     <span class="slider round"></span>
                                         </label></td>
                                  
                                <td><button type='button' class='btn btn-outline-dark' onclick='viewItem(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-info' onclick='editItem(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>
                           
                            <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteItem(${response.data.id})">
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
                                $('.updateIteform')[0].reset();
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
        function deleteItem(id) {
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
                                $('#itemTable').DataTable().row('.item' + response.data
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


        // restaurant change
        $(document).on('click', '.restaurant', function() {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: config.routes.getItems,
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success === true) {
                        $('.restaurant_id').val(response.data.id);
                        $('#itemTable').DataTable().clear().draw();
                        $('.category_select_box').empty();
                        $('.category_select_box').append(
                            `<option value=""></option>`
                        );
                        setSessionId(response.data.session_id); // set restaurant id into session
                        setRestaurant(response.data.name, response.data.id);  // set restaurant into topbar
                         
                        $.each(response.data.categories, function(i, category) {
                            console.log(category);
                            $('.category_select_box').append(
                                `<option value="${category.category_id}">${category.name}</option>`
                            );
                        });
                        if ($.trim(response.data)) {
                            var itemTable = $('#itemTable').DataTable();
                            $.each(response.data.items, function(key, val) {
                                var trDOM = itemTable.row.add([
                                    "" + val.category.name + "",
                                    `<img class="img-fluid" src="${imagesUrl}` +
                                    `${val.image}" style='width: 60px; height: 55px;'>`,
                                    "" + val.name + "",
                                    "" + val.price + "",
                                    `<label class="switch">
                                            <input class="is_available status${ val.item_id}"type="checkbox"
                                                ${val.is_available == 1 ? 'checked' : ''} data-id="${val.item_id}">
                                                     <span class="slider round"></span>
                                    </label>`,
                                    `   <button type='button' class='btn btn-outline-dark' onclick='viewItem(${val.item_id})'>
                                            <i class='fa fa-eye'></i>
                                        </button>
                                        <button type='button' class='btn btn-outline-info' onclick='editItem(${val.item_id})'>
                                            <i class='mdi mdi-pencil'></i>
                                        </button>
                                        <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteItem(${val.item_id})">
                                            <i class="mdi mdi-delete "></i>
                                        </button>`
                                ]).draw().node();
                                $(trDOM).addClass('item' + val.item_id + '');
                            });
                        }


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
        });

        // available status change function
        $(document.body).on('click', '.is_available', function() {
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
                        url: config.routes.updateAvailableStatus,
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
