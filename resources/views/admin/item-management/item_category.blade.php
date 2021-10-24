@extends('layouts.admin.master')
@section('page-header')
    Item Categories
@endsection
@section('restaurant_list')
@include('layouts.admin.restaurant_drop-down')
@endsection
@section('pageCss')
    <style>
        .view-modal-footer {
            display: initial !important;
        }

        .modal-footer>:not(:first-child) {
            margin-left: 0;
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
                                    <h4 class="mt-0 header-title">All Item Categories</h4>
                                </div>

                                <button type="button" class="btn btn-outline-purple float-right waves-effect waves-light"
                                    name="button" id="addButton" data-toggle="modal" data-target="#add"> Add
                                    New
                                </button>



                            </div>

                            <span class="showError"></span>
                            <div class="table-responsive">
                                <table id="categoryTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Item Category Name</th>
                                            <th>Item Category Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($categories))
                                            @foreach ($categories as $category)
                                                <tr class="category{{ $category->category_id }}">
                                                    <td>{{ $category->name }}</td>
                                                    <td>{{ $category->formated_description }}...</td>

                                                    <td>

                                                        <button type='button' class='btn btn-outline-dark'
                                                            onclick='viewCategory({{ $category->category_id }})'><i
                                                                class='fa fa-eye'></i></button>

                                                        <button type='button' name='delete' class="btn btn-outline-danger "
                                                            onclick="deleteCategory({{ $category->category_id }})"><i
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
                    <h5 class="modal-title mt-0 text-center">Add a new Category</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="categoryAddForm" method="POST"> @csrf
                        <input type="hidden" name="restaurant_id" value="{{ $restaurant->restaurant_id }}"
                            class="restaurant_id">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Type name" />
                        </div>
                        <div class="form-group">
                            <label>Category Description</label>
                            <textarea name="description" id="" class="form-control" cols="30" rows="5"></textarea>
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
                    <h5 class="modal-title mt-0 text-center">Update a Category</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="updateHeroSectionForm" method="POST"> @csrf
                        <input type="hidden" name="hidden_id" id="hidden_id">
                        <input type="hidden" name="restaurant_id" class="restaurant_id"
                            value="{{ $restaurant->restaurant_id }}">

                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" placeholder="Type name" />
                        </div>
                        <div class="form-group">
                            <label>Category Description</label>
                            <textarea name="description" id="edit_description" class="form-control" cols="30"
                                rows="5"></textarea>
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
                    <h5 class="modal-title mt-0 text-center">Category Details</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group">
                            <p class="pt-2 pb-2">
                                <strong>Name:</strong> <span id="view_name"></span><br>
                                <strong>Description:</strong> <span id="view_description"></span><br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer view-modal-footer">
                    <button id="editBtn" type="button" data-dismiss="modal"
                        class="btn btn-block btn-primary waves-effect waves-light" onclick="editCategory()">
                        Edit
                    </button>
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
    <script type='text/javascript'>
     CKEDITOR.replace('restaurant_description');
        var config = {
            routes: {
                add: "{!! route('item.category.store') !!}",
                edit: "{!! route('item.category.edit') !!}",
                view: "{!! route('item.category.show') !!}",
                update: "{!! route('item.category.update') !!}",
                delete: "{!! route('item.category.delete') !!}",
                getCategories: "{!! route('item.category.restaurant') !!}",
            }
        };

        $('#addButton').on('click', function() {
            $('.categoryAddForm').trigger('reset');
        });

        $(document).ready(function() {
            $('#categoryTable').DataTable({
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
            $(".categoryAddForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 100,
                    },
                    description: {
                        required: true,
                        maxlength: 10000,
                    },
                },
                messages: {
                    name: {
                        required: 'Please insert category name',
                    },
                    description: {
                        required: 'Please insert category description',
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
                    name: {
                        required: true,
                        maxlength: 100,
                    },
                    description: {
                        required: true,
                        maxlength: 10000,
                    },
                },
                messages: {
                    name: {
                        required: 'Please insert category name',
                    },
                    description: {
                        required: 'Please insert category description',
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

        $(document).on('submit', '.categoryAddForm', function(event) {
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
                        var categoryTable = $('#categoryTable').DataTable();
                        var row = $('<tr>')
                            .append(`<td>` + response.data.name + `</td>`)
                            .append(`<td>` + response.data.formated_description + `</td>`)

                            .append(`<td><button type='button' class='btn btn-outline-dark' onclick='viewCategory(${response.data.category_id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                         
                            <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteCategory(${response.data.category_id})">
                                <i class="mdi mdi-delete "></i>
                            </button></td>`)


                        var category_row = categoryTable.row.add(row).draw().node();
                        $('#categoryTable tbody').prepend(row);
                        $(category_row).addClass('category' + response.data.category_id + '');
                        $('.categoryAddForm').trigger('reset');
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
        function viewCategory(id) {
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
                        $('#editBtn').attr('onClick', `editCategory(${response.data.category_id});`);
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

        function editCategory(id) {
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
                        $('#hidden_id').val(response.data.category_id)

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
                            $('.category' + response.data.category_id).html(
                                `
                                <td>${response.data.name}</td>
                                <td>${response.data.formated_description}...</td>
                                  
                                <td><button type='button' class='btn btn-outline-dark' onclick='viewCategory(${response.data.category_id})'>
                                <i class='fa fa-eye'></i>
                            </button>

                           
                            <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteCategory(${response.data.category_id})">
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
        function deleteCategory(id) {
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
                                $('#categoryTable').DataTable().row('.category' + response.data
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
                url: config.routes.getCategories,
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success === true) {
                        $('.restaurant_id').val(response.data.id);
                        $('#categoryTable').DataTable().clear().draw();
                        setSessionId(response.data.session_id); // set restaurant id into session
                        setRestaurant(response.data.name, response.data.id);  // set restaurant into topbar

                        if($.trim(response.data) ){
                            var categoryTable = $('#categoryTable').DataTable();
                            $.each(response.data.categories,function(key,val){
                            var trDOM = categoryTable.row.add([
                                    "" + val.name + "",
                                    "" + val.description + "",
                                    `   <button type='button' class='btn btn-outline-dark' onclick='viewCategory(${val.category_id})'>
                                            <i class='fa fa-eye'></i>
                                        </button>
                                        <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteCategory(${val.category_id})">
                                            <i class="mdi mdi-delete "></i>
                                        </button>`
                                ]).draw().node();
                                $(trDOM).addClass('category' + val.category_id + '');
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
