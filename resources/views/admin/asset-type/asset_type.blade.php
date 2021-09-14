@extends('layouts.admin.master')
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
                                    <h4 class="mt-0 header-title">All Asset Types</h4>
                                </div>

                                <button type="button" class="btn btn-outline-purple float-right waves-effect waves-light"
                                    name="button" id="addButton" data-toggle="modal" data-target="#add"> Add
                                    New
                                </button>



                            </div>

                            <span class="showError"></span>
                            <div class="table-responsive">
                                <table id="AssetTypeTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($asset_types))
                                            @foreach ($asset_types as $asset_type)
                                                <tr class="asset_type{{ $asset_type->asset_type_id }}">
                                                    <td>{{ $asset_type->name }}</td>
                                                    <td>

                                                        <button type='button' class='btn btn-outline-purple'
                                                            onclick='viewAssetType({{ $asset_type->asset_type_id }})'><i
                                                                class='fa fa-eye'></i></button>
                                                        <button type='button' class='btn btn-outline-purple '
                                                            onclick='editAssetType({{ $asset_type->asset_type_id }})'><i
                                                                class='mdi mdi-pencil'></i></button>
                                                        <button type='button' class="btn btn-outline-danger "
                                                            onclick="deleteAssetType({{ $asset_type->asset_type_id }})"><i
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
                    <h5 class="modal-title mt-0 text-center">Add New</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="assetTypeAddForm" method="POST"> @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Type name"/>
                        </div>
                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-purple waves-effect waves-light">
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
                    <h5 class="modal-title mt-0 text-center">Update Asset Type's Info</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="updateAssetTypeForm" method="POST"> @csrf
                        <input type="hidden" name="hidden_id" id="hidden_id">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name"
                                placeholder="Type name" />
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-purple waves-effect waves-light">
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
                    <h5 class="modal-title mt-0 text-center"> Asset Type's Details</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group">
                            <label for="name"><strong>Name:</strong></label>
                            <p id="view_name"></p>
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
                add: "{!! route('asset.type.store') !!}",
                edit: "{!! route('asset.type.edit') !!}",
                view: "{!! route('asset.type.show') !!}",
                update: "{!! route('asset.type.update') !!}",
                delete: "{!! route('asset.type.delete') !!}",
            }
        };

        $('#addButton').on('click', function() {
            $('.assetTypeAddForm').trigger('reset');
        });

        $(document).ready(function() {
            $('#AssetTypeTable').DataTable({
                "ordering": false,
            });
        });




        $(document).ready(function() {
            // add form validation
            $(".assetTypeAddForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 100,
                    },
                },
                messages: {
                    name: {
                        required: 'Please insert asste type name',
                    },
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
                    label.insertAfter(element);
                },
            });
            // update form validation
            $(".updateAssetTypeForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 100,
                    },
                },
                messages: {
                    name: {
                        required: 'Please insert asste type name',
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
        $(document).on('submit', '.assetTypeAddForm', function(event) {
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
                        var AssetTypeTable = $('#AssetTypeTable').DataTable();
                        var row = $('<tr>')
                            .append(`<td>` + response.data.name + `</td>`)
                            .append(`<td><button type='button' class='btn btn-outline-purple' onclick='viewAssetType(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-purple' onclick='editAssetType(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>      <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteAssetType(${response.data.id})">
                                <i class="mdi mdi-delete "></i>
                            </button></td>
                           
                         `)
                   
                        var asset_type_row = AssetTypeTable.row.add(row).draw().node();
                        $('#AssetTypeTable tbody').prepend(row);
                        $(asset_type_row).addClass('asset_type' + response.data.id + '');
                        $('.AssetTypeAddForm').trigger('reset');
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
        function viewAssetType(id) {
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

        function editAssetType(id) {
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
                        $('#hidden_id').val(response.data.asset_type_id)
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
            
            $(document).off('submit', '.updateAssetTypeForm');
            $(document).on('submit', '.updateAssetTypeForm', function(event) {
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
                            $('.asset_type' + response.data.id).html(
                                `
                                <td>${response.data.name}</td> 
                                <td>
                                    <button type='button' class='btn btn-outline-purple' onclick='viewAssetType(${response.data.id})'>
                                         <i class='fa fa-eye'></i>
                                    </button>
                                    <button type='button' class='btn btn-outline-purple' onclick='editAssetType(${response.data.id})'>
                                        <i class='mdi mdi-pencil'></i>
                                    </button>
                                   <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteAssetType(${response.data.id})">
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
                                $('.updateAssetTypeForm')[0].reset();
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
        function deleteAssetType(id) {
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
                                $('#AssetTypeTable').DataTable().row('.asset_type' + response.data
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
