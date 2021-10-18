@extends('layouts.admin.master')
@section('page-header')
    Item Combos
@endsection
@section('restaurant_list')
    @include('layouts.admin.restaurant_drop-down')
@endsection
@section('pageCss')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                                    <h4 class="mt-0 header-title">All Item Combos</h4>
                                </div>

                                <button type="button" class="btn btn-outline-purple float-right waves-effect waves-light"
                                    name="button" id="addButton" data-toggle="modal" data-target="#add"> Add
                                    New
                                </button>



                            </div>

                            <span class="showError"></span>
                            <div class="table-responsive">
                                <table id="comboTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Combo Name</th>
                                            <th>Photo</th>
                                            <th>Item(s) Name</th>
                                            <th>Unit Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($combos))
                                            @foreach ($combos as $combo)
                                                <tr class="combo{{ $combo->combo_id }}">
                                                    <td>{{ $combo->name }}</td>
                                                    <td>
                                                        <img class='img-fluid'
                                                            src="{{ asset('images/' . $combo->photo) }}"
                                                            alt="{{ $combo->name }}" style='width: 60px; height: 55px;'>
                                                    </td>
                                                    <td>
                                                        @foreach ($combo->items as $item)
                                                            {{ $item->name }},
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $combo->price }}</td>
                                                    <td>
                                                        <button type='button' class='btn btn-outline-dark'
                                                            onclick='viewCombo({{ $combo->combo_id }})'><i
                                                                class='fa fa-eye'></i></button>
                                                        <button type='button' class='btn btn-outline-info '
                                                            onclick='editCombo({{ $combo->combo_id }})'><i
                                                                class='mdi mdi-pencil'></i></button>

                                                        <button type='button' name='delete' class="btn btn-outline-danger "
                                                            onclick="deleteCombo({{ $combo->combo_id }})"><i
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
                    <h5 class="modal-title mt-0 text-center">Add a new Combo</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="comboAddForm" method="POST"> @csrf
                        <input type="hidden" name="restaurant_id" value="{{ $restaurant->restaurant_id }}"
                            class="restaurant_id">
                        <div class="form-group">
                            <label>Combo Name</label>
                            <input type="text" class="form-control" name="name" />
                        </div>
                        <div class="form-group">
                            <label>Select Item(s)</label>
                            <select name="item[]" class="form-control item-select-box" id="" multiple="multiple">
                                @if (!empty($items))
                                    @foreach ($items as $item)
                                        <option value="{{ $item->item_id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label id="item[]-error" class="error mt-2 text-danger" for="item[]"></label>
                        </div>
                        <div class="form-group">
                            <label>Price </label>
                            <input type="number" class="form-control" name="price" />
                        </div>
                        <div class="form-group ">
                            <label for="">Combo Photo</label>
                            <div class="custom-file">
                                <input type="file" name="photo" class="custom-file-input dropify"
                                    data-errors-position="outside" data-allowed-file-extensions='["jpg", "png","jpeg"]'
                                    data-max-file-size="0.6M" data-height="80">
                            </div>
                            <label id="photo-error" class="error mt-2 text-danger" for="photo"></label>
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
                    <h5 class="modal-title mt-0 text-center">Update a combo</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="updateComboForm" method="POST"> @csrf
                        <input type="hidden" name="hidden_id" id="hidden_id">
                        <input type="hidden" name="restaurant_id" class="restaurant_id"
                            value="{{ $restaurant->restaurant_id }}">

                        <div class="form-group">
                            <label>combo Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" placeholder="Type name" />
                        </div>
                        <div class="form-group">
                            <label>Select Item(s)</label>
                            <select name="item[]" class="form-control item-select-box" id="edit_item_select_box" multiple="multiple">
                                @if (!empty($items))
                                    @foreach ($items as $item)
                                        <option value="{{ $item->item_id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label id="item[]-error" class="error mt-2 text-danger" for="item[]"></label>
                        </div>
                        <div class="form-group">
                            <label>Price </label>
                            <input type="number" class="form-control" name="price" id="edit_price" />
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
                    <h5 class="modal-title mt-0 text-center">Combo Details</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group">
                            <p>
                                <strong>Combo Name:</strong> <span id="view_name"></span>
                            </p>
                            <p>
                                <strong>Item(s) Name:</strong> <span id="view_item_name"></span>
                            </p>
                            <p>
                                <strong>Unit Price:</strong> <span id="view_price"></span>
                            </p>
                            <img class="mt-2" src="" id="view_image" style="width: 100%;">
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

    @include('layouts.admin.restaurant_add_modal')
@endsection
@section('pageScripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type='text/javascript'>
        var imagesUrl = '{!! URL::asset('/images/') !!}/';
        var config = {
            routes: {
                add: "{!! route('item.combo.store') !!}",
                edit: "{!! route('item.combo.edit') !!}",
                view: "{!! route('item.combo.show') !!}",
                update: "{!! route('item.combo.update') !!}",
                delete: "{!! route('item.combo.delete') !!}",
                getCombos: "{!! route('item.combo.restaurant') !!}",
            }
        };

        $('#addButton').on('click', function() {
            $('.comboAddForm').trigger('reset');
        });

        $(document).ready(function() {
            $('#comboTable').DataTable({
                "ordering": false,
            });

        });

        $(document).ready(function() {
            $('.item-select-box').select2();
        });


        $(document).ready(function() {
            // add form validation
            $(".comboAddForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 100,
                    },
                    price: {
                        required: true,
                        digits: true,
                    },
                    "item[]": "required",
                    photo: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please insert combo name',
                    },
                    price: {
                        required: 'Please insert combo price',
                    },
                    photo: {
                        required: 'Please upload a photo',
                    },
                    "item[]": "Please select a item",
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
                    label.insertAfter(element);
                },
            });
            // update form validation
            $(".updateComboForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 100,
                    },
                    price: {
                        required: true,
                        digits: true,
                    },
                    "item[]": "required",
                },
                messages: {
                    name: {
                        required: 'Please insert combo name',
                    },
                    price: {
                        required: 'Please insert combo price',
                    },
                    "item[]": "Please select a item",
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
                    label.insertAfter(element);
                },
            });
        });
        //end

        // add  request

        $(document).on('submit', '.comboAddForm', function(event) {
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
                        var comboTable = $('#comboTable').DataTable();
                        var row = $('<tr>')
                            .append(`<td>` + response.data.name + `</td>`)
                            .append(`<td><img class="img-fluid" src="${imagesUrl}` +
                                `${response.data.image}" style='width: 60px; height: 55px;'></td>`)
                            .append(`<td>` + response.data.item_name + `</td>`)
                            .append(`<td>` + response.data.price + `</td>`)

                            .append(`<td><button type='button' class='btn btn-outline-dark' onclick='viewCombo(${response.data.combo_id})'>
                                            <i class='fa fa-eye'></i>
                                        </button>
                                        <button type='button' class='btn btn-outline-info'onclick='editCombo(${response.data.combo_id})'>
                                            <i class='mdi mdi-pencil'></i>
                                        </button>
                         
                                        <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteCombo(${response.data.combo_id})">
                                            <i class="mdi mdi-delete "></i>
                                        </button>
                                   </td>`)


                        var combo_row = comboTable.row.add(row).draw().node();
                        $('#comboTable tbody').prepend(row);
                        $(combo_row).addClass('combo' + response.data.combo_id + '');
                        $('.comboAddForm').trigger('reset');
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
        function viewCombo(id) {
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
                        $('#view_name').text(response.data.name);
                        $.each(response.data.items, function(i, val) {
                            $('#view_item_name').append(
                                `<span id="view_item_name">${val.name}, </span>`
                            )
                        });

                        $('#view_price').text(response.data.price);
                        if (response.data.photo != null) {
                            $('#view_image').attr('src', imagesUrl + response.data.photo);
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

        function editCombo(id) {
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
                        $('#edit_price').val(response.data.price)
                        $('#hidden_id').val(response.data.combo_id)
                        if (response.data.photo) {
                            var photo = imagesUrl + response.data.photo;
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
                        var items_id=[];
                         $.each(response.data.items, function(key,value){
                            items_id.push(value.item_id)
                          });  

                        $('#edit_item_select_box').val(items_id);
                        $('#edit_item_select_box').trigger('change');

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

            $(document).off('submit', '.updateComboForm');
            $(document).on('submit', '.updateComboForm', function(event) {
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
                            $('.combo' + response.data.combo_id).html(
                                `
                                <td>${response.data.name}</td>
                                <td><img class="img-fluid" src="${imagesUrl}` +
                                `${response.data.image}" style='width: 60px; height: 55px;'></td>
                                <td>${response.data.item_name}</td>
                                <td>${response.data.price}</td>
                                  
                                <td><button type='button' class='btn btn-outline-dark' onclick='viewCombo(${response.data.combo_id})'>
                                            <i class='fa fa-eye'></i>
                                        </button>
                                        <button type='button' class='btn btn-outline-info'onclick='editCombo(${response.data.combo_id})'>
                                            <i class='mdi mdi-pencil'></i>
                                        </button>
                         
                                        <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteCombo(${response.data.combo_id})">
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
                                $('.updateComboForm')[0].reset();
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
        function deleteCombo(id) {
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
                                $('#comboTable').DataTable().row('.combo' + response.data
                                        .combo_id)
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
                url: config.routes.getCombos,
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success === true) {
                        $('.restaurant_id').val(response.data.id);
                        $('#comboTable').DataTable().clear().draw();
                        setSessionId(response.data.session_id); // set restaurant id into session
                        setRestaurant(response.data.name, response.data
                        .id); // set restaurant into topbar

                        $('.item-select-box').empty();
                        $.each(response.data.items, function(i, item) {
                            $('.item-select-box').append(
                                `<option value="${item.item_id}">${item.name}</option>`
                            );
                        });

                        if ($.trim(response.data)) {
                            var comboTable = $('#comboTable').DataTable();
                            $.each(response.data.combos, function(key, val) {
                                var items_id=[];
                                $.each(val.items, function(i,value){
                                    items_id.push(value.name)
                                }); 
                                        var trDOM = comboTable.row.add([
                                    "" + val.name + "",
                                    `<img class="img-fluid" src="${imagesUrl}` +
                                    `${val.photo}" style='width: 60px; height: 55px;'>`,
                                    "" + items_id + "",
                                    "" + val.price + "",
                                    
                                   
                                    ` <button type='button' class='btn btn-outline-dark' onclick='viewCombo(${val.combo_id})'>
                                            <i class='fa fa-eye'></i>
                                        </button>
                                        <button type='button' class='btn btn-outline-info'onclick='editCombo(${val.combo_id})'>
                                            <i class='mdi mdi-pencil'></i>
                                        </button>
                         
                                        <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteCombo(${val.combo_id})">
                                            <i class="mdi mdi-delete "></i>
                                        </button>`
                                ]).draw().node();
                                $(trDOM).addClass('combo' + val.combo_id + '');
                                console.log(val.item_name);
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
    </script>
@endsection
