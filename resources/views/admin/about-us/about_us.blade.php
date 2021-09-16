@extends('layouts.admin.master')
@section('page-header')
    About Us Section
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
                                    <h4 class="mt-0 header-title">About Us Section</h4>
                                </div>

                                {{-- <button type="button" class="btn btn-outline-purple float-right waves-effect waves-light"
                                    name="button" id="addButton" data-toggle="modal" data-target="#add"> Add
                                    New
                                </button> --}}



                            </div>

                            <span class="showError"></span>
                            <div class="table-responsive">
                                <table id="AboutUsTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Photo</th>
                                            <th>Heading</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($abouts))
                                            @foreach ($abouts as $about)
                                                <tr class="hero_section{{ $about->about_us_id }}">
                                                    <td><img class="img-fluid"
                                                        src="{{ asset('images/' . $about->pic) }}"
                                                        style="width: 60px; height: 55px;">
                                                    </td>
                                                    <td>{{ $about->heading }}</td>
                                                    <td>{{ $about->formated_description }}...</td>                                          
                                                    <td>
                                                        <button type='button' class='btn btn-outline-dark'
                                                            onclick='viewAboutUs({{ $about->about_us_id }})'><i
                                                                class='fa fa-eye'></i></button>
                                                        <button type='button' class='btn btn-outline-info '
                                                            onclick='editAboutUs({{ $about->about_us_id }})'><i
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
                    <form class="AboutUsAddForm" method="POST"> @csrf
                        <div class="form-group">
                            <label>Heading</label>
                            <input type="text" class="form-control" name="heading" placeholder="Type name" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="" class="form-control" cols="30" rows="5"></textarea>
                        </div>




                        <div class="form-group ">
                            <label>Image</label>
                            <div class="custom-file">
                                <input type="file" name="pic" class="custom-file-input dropify"
                                    data-errors-position="outside" data-allowed-file-extensions='["jpg", "png"]'
                                    data-max-file-size="0.6M">
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
                    <h5 class="modal-title mt-0 text-center">Update About Us</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="updateAboutUsForm" method="POST"> @csrf
                        <input type="hidden" name="hidden_id" id="hidden_id">

                        <div class="form-group">
                            <label>Heading</label>
                            <input type="text" class="form-control" id="edit_heading" name="heading"
                                placeholder="Type name" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="edit_description" class="form-control" cols="30"
                                rows="5"></textarea>
                        </div>


                        <div class="form-group ">
                            <label>Image</label>
                            <div class="custom-file edit_hero_section_photo">
                                <input type="file" name="pic" id="edit_hero_section_photo" class="custom-file-input dropify"
                                    data-max-file-size="0.6M" data-errors-position="outside"
                                    data-allowed-file-extensions='["jpg", "png"]'>
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
                    <h5 class="modal-title mt-0 text-center">About Us Details</h5>
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
                            <label for="name"><strong>Heading:</strong></label>
                            <p id="view_heading"></p>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group">
                            <label for="name"><strong>Description:</strong></label>
                            <p id="view_description"></p>
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
                edit: "{!! route('about.us.edit') !!}",
                view: "{!! route('about.us.show') !!}",
                update: "{!! route('about.us.update') !!}",
                delete: "{!! route('about.us.delete') !!}",
            }
        };

        $('#addButton').on('click', function() {
            $('.dropify-preview').hide();
            $('.AboutUsAddForm').trigger('reset');
        });

        var imagesUrl = '{!! URL::asset('/images/') !!}/';
        $(document).ready(function() {
            $('#AboutUsTable').DataTable({
                "ordering": false,
            });
            $('.dropify').dropify();
            $('.signature_input_box').hide();
        });




        $(document).ready(function() {
            // add form validation
            $(".AboutUsAddForm").validate({
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
            $(".updateAboutUsForm").validate({
                rules: {
                    heading: {
                        required: true,
                        maxlength: 100,
                    },
                    description: {
                        required: true,
                        maxlength: 10000,
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

        $(document).on('submit', '.AboutUsAddForm', function(event) {
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
                        var AboutUsTable = $('#AboutUsTable').DataTable();
                        var row = $('<tr>')
                            .append(`<td><img class="img-fluid" src="${imagesUrl}` +
                                `${response.data.image}" style='width: 60px; height: 55px;'></td>`)
                            .append(`<td>` + response.data.heading + `</td>`)
                            .append(`<td>` + response.data.description + `</td>`)
                          
                            .append(`<td><button type='button' class='btn btn-outline-dark' onclick='viewAboutUs(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-info' onclick='editAboutUs(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>
                           
                         `)
                        //  <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteAboutUs(${response.data.id})">
                        //         <i class="mdi mdi-delete "></i>
                        //     </button></td>


                        var hero_section_row = AboutUsTable.row.add(row).node();
                        $('#AboutUsTable tbody').prepend(row);
                        $(hero_section_row).addClass('hero_section' + response.data.id + '');
                        $('.AboutUsAddForm').trigger('reset');
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
        function viewAboutUs(id) {
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
                        $('#view_heading').text(response.data.heading);
                        $('#view_description').text(response.data.description);
                        if (response.data.pic === null) {
                            $('#view_image').removeAttr('src');
                        } else {
                            $('#view_image').attr('src', '/images/' + response.data.pic);
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

        function editAboutUs(id) {
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
                        $('#edit_heading').val(response.data.heading)
                        $('#edit_description').val(response.data.description)
                        $('#hidden_id').val(response.data.about_us_id)

                        if (response.data.pic) {
                            var photo = imagesUrl + response.data.pic;
                            $("#edit_hero_section_photo").attr("data-height", 150);
                            $("#edit_hero_section_photo").attr("data-min-width", 450);
                            $("#edit_hero_section_photo").attr("data-default-file", photo);
                            $('.edit_hero_section_photo').find(".dropify-wrapper").removeClass(
                                "dropify-wrapper").addClass(
                                "dropify-wrapper has-preview");
                            $('.edit_hero_section_photo').find(".dropify-preview").css('display', 'block');
                            $('.edit_hero_section_photo').find('.dropify-render').html('').html('<img src=" ' +
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
            
            $(document).off('submit', '.updateAboutUsForm');
            $(document).on('submit', '.updateAboutUsForm', function(event) {
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
                            $('.hero_section' + response.data.id).html(
                                `
                                <td><img class="img-fluid" src="${imagesUrl}` + `${response.data.image}" style='width: 60px; height: 55px;'></td>   
                                <td>${response.data.heading}</td>
                                <td>${response.data.description}...</td>
                                  
                                <td><button type='button' class='btn btn-outline-dark' onclick='viewAboutUs(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-info' onclick='editAboutUs(${response.data.id})'>
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
                                $('.updateAboutUsForm')[0].reset();
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
        function deleteAboutUs(id) {
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
                                $('#AboutUsTable').DataTable().row('.hero_section' + response.data
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
