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

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
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
                                    <h4 class="mt-0 header-title">All Users</h4>
                                </div>
                                 @if(Auth::user()->is_super_admin==1||Auth::user()->is_admin==1)
                                    <button type="button"
                                        class="btn btn-outline-purple float-right waves-effect waves-light" name="button"
                                        id="addButton" data-toggle="modal" data-target="#add"> Add
                                        New
                                    </button>
                                    @endif
                               

                            </div>

                            <span class="showError"></span>
                            <table id="userTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                       
                                       
                                       <th>Role</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Image</th>
                                        @if(Auth::user()->is_super_admin==1)
                                       <th>Is Admin</th>
                                        @endif
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($users))
                                        @foreach ($users as $user)
                                            <tr class="user{{ $user->id }}">
                                                
                                               
                                                @if($user->is_admin==1)
                                                 <td class="change_role{{$user->id}}">Admin</td>
                                                 @else
                                                 <td class="change_role{{$user->id}}">User</td>
                                                @endif
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                 <td><img class="img-fluid" src="{{asset('images/'.$user->image)}}" style="width: 60px; height: 55px;"></td>
                                                @if(Auth::user()->is_super_admin==1)
                                               <td><label class="switch">
                                                <input class="is_admin status{{ $user->id }}" type="checkbox" {{ $user->is_admin==1 ? 'checked' : '' }} {{ Auth::user()->id==$user->id ? 'disabled' : '' }} data-id="{{$user->id}}">
                                                <span class="slider round"></span>
                                              </label></td>
                                                @endif

                                                
                                                <td>

                                                    

                                                        @if(Auth()->user()->is_super_admin==1)
                                                        <button type='button' class='btn btn-outline-purple'
                                                        onclick='viewUser({{ $user->id }})'><i
                                                            class='fa fa-eye'></i></button> 
                                                        <button type='button' class='btn btn-outline-purple '
                                                            onclick='editUser({{ $user->id }})'><i
                                                                class='mdi mdi-pencil'></i></button>
                                                        <button type='button' name='delete' class="btn btn-outline-danger "
                                                            onclick="deleteUser({{ $user->id }})"><i
                                                                class="mdi mdi-delete "></i></button>
                                                        @elseif(Auth()->user()->is_admin!=1 && Auth()->user()->is_super_admin!=1)
                                                        <button type='button' class='btn btn-outline-purple'
                                                        onclick='viewUser({{ $user->id }})'><i
                                                            class='fa fa-eye'></i></button>
                                                            @else
                                                            <button type='button' class='btn btn-outline-purple'
                                                        onclick='viewUser({{ $user->id }})'><i
                                                            class='fa fa-eye'></i></button> 
                                                        <button type='button' class='btn btn-outline-purple '
                                                        @if($user->is_admin == 1 && Auth()->user()->id != $user->id) disabled="" @endif
                                                             onclick='editUser({{ $user->id }})'><i
                                                                class='mdi mdi-pencil'></i></button>
                                                        <button type='button' name='delete' class="btn btn-outline-danger "
                                                          @if($user->is_admin == 1 ) disabled="" @endif  onclick="deleteUser({{ $user->id }})"><i
                                                                class="mdi mdi-delete "></i></button>
                                                        @endif


                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                    </tr>
                                </tfoot>
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
                    <h5 class="modal-title mt-0 text-center">Add New User</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="employeeAddForm" method="POST"> @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Type name" />
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Type phone no" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Type email" />
                        </div>
                        <div class="form-group">
                            @if (Auth()->user()->is_super_admin == 1)
                                <div class="row">
                                  
                                    <div class="col-md-6">
                                        
                                        <label class="ms-checkbox-wrap ms-checkbox-dark">
                                            <input type="checkbox" value="1" name="is_admin">
                                            <i class="ms-checkbox-check"></i>
                                        </label>&nbsp
                                        <span>Is Admin </span>
                                    </div>
                                </div>
                            
                            @endif
                        </div>
                        

                        <div class="form-group ">
                            <label>Image(200*200)</label>
                            <div class="custom-file">
                                <div class="col-md-8 offset-2">
                                    <input type="file" name="profile_image" class="custom-file-input dropify"
                                    data-errors-position="outside" data-allowed-file-extensions='["jpg", "png"]'
                                    data-max-file-size="0.6M" data-height="260" data-width="220">
                                </div>
                            </div>
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
                    <h5 class="modal-title mt-0 text-center">Update User's Info</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="updateemployeeForm" method="POST"> @csrf
                        <input type="hidden" name="hidden_id" id="hidden_id">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name"
                                placeholder="Type name" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" id="edit_email"
                                placeholder="Type email" />
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" id="edit_phone"
                                placeholder="Type phone no" />
                        </div>
                        @if (Auth()->user()->is_super_admin == 1)
                            <div class="form-group">
                                <div class="row">
                                   
                                    <div class="col-md-6">
                                       
                                        <label class="ms-checkbox-wrap ms-checkbox-dark">
                                            <input type="checkbox" value="1" class="admin_checkbox" name="is_admin">
                                            <i class="ms-checkbox-check"></i>
                                        </label>
                                        <span>Is Admin </span>&nbsp
                                    </div>
                                </div>

                            </div>
                        
                        @endif
                       
                        <div class="form-group ">
                            <label>Image(200*200)</label>
                            <div class="custom-file edit_profile_image">
                                 <div class="col-md-8 offset-2">
                                <input type="file" name="profile_image" id="edit_profile_image" class="custom-file-input dropify"
                                    data-max-file-size="0.6M" data-errors-position="outside" data-height="260" data-width="220">
                                </div>
                            </div>
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
                    <h5 class="modal-title mt-0 text-center">User's Details</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 col-md-12 text-center signature_row mb-3">
                        <div class="ms-form-group">
                            {{-- <label for="name"><strong>Logo:</strong></label> --}}
                            <img src="" id="view_image" class="view_employee_signature">
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 text-center mb-3">
                        <div class="ms-form-group" style="font-size: 16px;">
                             <span class="badge badge-primary  p-1 view_role"></span>
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
        var toastMixin = Swal.mixin({
            toast: true,
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        var config = {
            routes: {
                add: "{!! route('admin.store') !!}",
                edit: "{!! route('admin.edit') !!}",
                view: "{!! route('admin.show') !!}",
                update: "{!! route('admin.update') !!}",
                delete: "{!! route('admin.delete') !!}",
                is_admin: "{!! route('is.admin') !!}",
            }
        };

        $('#addButton').on('click', function() {
            $('.dropify-preview').hide();
            $('.employeeAddForm').trigger('reset');
        });

        var imagesUrl = '{!! URL::asset('/images/') !!}';
        $(document).ready(function() {
            // data table
            // $('#userTable').DataTable({
            //     "ordering": false,
            // });
            // dropify table
            $('.dropify').dropify();
            $('.signature_input_box').hide();
        });

        $(document).ready(function() {
            $('#userTable').DataTable({
                "ordering": false,
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        // alert(column);
                        var select = $(
                                '<select class="form-control filter_by_role"><option value="">Filter by Role</option></select>'
                                )
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d +
                                '</option>')
                        });
                    });
                }
            });

            $('#userTable tfoot tr').prependTo('#userTable thead');
            $('.loader').hide();

        });

        // add form validation
        $(document).ready(function() {
            $(".employeeAddForm").validate({
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
                    
                    
                    profile_image: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please insert user name',
                    },
                    email: {
                        required: 'Please insert user email',
                    },
                    phone: {
                        required: 'Please insert user phone number',
                    },
                    image: {
                        required: 'Please upload user signature',
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

        $(document).on('submit', '.employeeAddForm', function(event) {
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
                        var userTable = $('#userTable').DataTable();
                       if (response.data.super_admin ==1) {
                        var row = $('<tr>')
                                    .append(`<td>`+ response.data.role +`</td>`)
                                    .append(`<td>`+ response.data.name +`</td>`)
                                    .append(`<td>`+ response.data.email +`</td>`)
                                    .append(`<td>`+ response.data.phone +`</td>`)
                                    .append(`<td><img class="img-fluid" src="${imagesUrl}`+'/'+`${response.data.image}" style='width: 60px; height: 55px;'></td>`)
                                    .append(`<td class="${response.data.id}">`+" <label class='switch'><input class='is_admin' type='checkbox' "+(response.data.role == 'Admin' ? 'checked': '' )+"  data-id='"+response.data.id+"'> <span class='slider round'></span> </label>" +`</td>`)
                                    .append(`<td><button type='button' class='btn btn-outline-purple' onclick='viewUser(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-purple' onclick='editUser(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>
                           
                            <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteUser(${response.data.id})">
                                <i class="mdi mdi-delete "></i>
                            </button></td>`)
                                    

                                var user_row=userTable.row.add(row).node();
                                $('#userTable tbody').prepend(row);
                                 $(user_row).addClass('user' + response.data.id + '');
                        // var trDOM = userTable.row.add([
                            
                        //     "" + response.data.role + "",
                        //     "" + response.data.name + "",
                        //     "" + response.data.email + "",
                        //     "" + response.data.phone + "",
                        //     "<label class='switch'><input class='is_admin' type='checkbox'  data-id='"+response.data.id+"'> <span class='slider round'></span> </label>",
                        //     "<img class='img-fluid' src='"+imagesUrl+"/"+response.data.image+"' style='width: 60px; height: 55px;'>",
                        //     `
                            // <button type='button' class='btn btn-outline-purple' onclick='viewUser(${response.data.id})'>
                            //     <i class='fa fa-eye'></i>
                            // </button>
                            // <button type='button' class='btn btn-outline-purple' onclick='editUser(${response.data.id})'>
                            //     <i class='mdi mdi-pencil'></i>
                            // </button>
                           
                            // <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteUser(${response.data.id})">
                            //     <i class="mdi mdi-delete "></i>
                            // </button>
                        //     `
                        // ]).draw().node();

                       }else{
                         var row = $('<tr>')
                                    .append(`<td>`+ response.data.role +`</td>`)
                                    .append(`<td>`+ response.data.name +`</td>`)
                                    .append(`<td>`+ response.data.email +`</td>`)
                                    .append(`<td>`+ response.data.phone +`</td>`)
                                    .append(`<td><img class="img-fluid" src="${imagesUrl}`+'/'+`${response.data.image}" style='width: 60px; height: 55px;'></td>`)                                    
                                    .append(`<td><button type='button' class='btn btn-outline-purple' onclick='viewUser(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-purple' onclick='editUser(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>
                           
                            <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteUser(${response.data.id})">
                                <i class="mdi mdi-delete "></i>
                            </button></td>`)
                                    

                                var user_row=userTable.row.add(row).node();
                                $('#userTable tbody').prepend(row);
                                 $(user_row).addClass('user' + response.data.id + '');
                       }
                        // $(trDOM).addClass('user' + response.data.id + '');
                        $('.employeeAddForm').trigger('reset');
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
                        // html = `<div class="alert alert-danger text-center" role="alert">
                        //             <strong>${response.data.error}</strong>.
                        //         </div>
                        //     `;
                        // $('.showError').fadeIn(100).html(html);
                        // $('.showError').fadeOut(5000);
                    }
                }, //success end

                // beforeSend: function() {
                   
                //     $('.preloader').empty();
                //     $('.preloader').addClass('ajax_loader').append(
                //         `<div class='preloader'>
                //             <div id="status">
                //                 <div class="spinner"></div>
                //             </div>
                //         </div>`
                //     );
                // },
                // complete: function() {
                //     $('.preloader').removeClass('ajax_loader').empty();
                // }
            });
        });

        //request end


        // view single 
        function viewUser(id) {
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
                        if (response.data.is_admin==1) {
                            var role='Admin'

                        }else{
                             var role='User'
                        }
                        $('.view_role').text(role);
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




        // Update product
        //validation
        $(document).ready(function() {
            $(".updateemployeeForm").validate({
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
                        required: 'Please insert user name',
                    },
                    email: {
                        required: 'Please insert user email',
                    },
                    phone: {
                        required: 'Please insert user phone number',
                    },
                    // image: {
                    //     required: 'Please upload user signature',
                    // },
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
                    label.insertAfter(element);
                },
            });
        });


        function editUser(id) {
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
                        var path = "{{ url('/') }}" + '/images/';
                        $('#edit_name').val(response.data.name)
                        $('#edit_email').val(response.data.email)
                        $('#edit_phone').val(response.data.phone)
                        
                        $('#hidden_id').val(response.data.id)
                         if (response.data.is_admin == 1) {
                            $('.admin_checkbox').prop('checked', true);
                        } else {
                            $('.admin_checkbox').prop('checked', false);
                        }
                       
                        
                        if (response.data.image) {
                            var profile_img_url = path + response.data.image;

                            $("#edit_profile_image").attr("data-height", 150);
                            $("#edit_profile_image").attr("data-min-width", 450);
                            $("#edit_profile_image").attr("data-default-file", profile_img_url);
                            $('.edit_profile_image').find(".dropify-wrapper").removeClass("dropify-wrapper").addClass(
                                "dropify-wrapper has-preview");
                            $('.edit_profile_image').find(".dropify-preview").css('display', 'block');
                            $('.edit_profile_image').find('.dropify-render').html('').html('<img src=" ' + profile_img_url +
                                '">')
                        } else {
                            $(".dropify-preview .dropify-render img").attr("src", "");
                        }


                        $('#edit_modal').modal('show');

                    } //success end

                }
            });
            $(document).off('submit', '.updateemployeeForm');
            $(document).on('submit', '.updateemployeeForm', function(event) {
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
                            if (response.data.super_admin==1) {
                                $('.user' + response.data.id).html(
                                `
                                <td>${response.data.role}</td>
                                <td>${response.data.name}</td>
                                <td>${response.data.email}</td>
                                <td>${response.data.phone}</td>
                                <td><img class="img-fluid" src="${imagesUrl}`+'/'+`${response.data.image}" style='width: 60px; height: 55px;'></td>
                                <td class="${response.data.id}"> <label class='switch'><input class='is_admin' type='checkbox' ${(response.data.role == 'Admin' ? 'checked': '' )}  data-id='${response.data.id}'> <span class='slider round'></span> </label></td>      
                                <td><button type='button' class='btn btn-outline-purple' onclick='viewUser(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-purple' onclick='editUser(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>
                           
                            <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteUser(${response.data.id})">
                                <i class="mdi mdi-delete "></i>
                            </button></td>
                                `
                            );
                            }
                                else{
                                    $('.user' + response.data.id).html(
                                `
                                <td>${response.data.role}</td>
                                <td>${response.data.name}</td>
                                <td>${response.data.email}</td>
                                <td>${response.data.phone}</td>
                                <td><img class="img-fluid" src="${imagesUrl}`+'/'+`${response.data.image}" style='width: 60px; height: 55px;'></td>     
                                <td><button type='button' class='btn btn-outline-purple' onclick='viewUser(${response.data.id})'>
                                <i class='fa fa-eye'></i>
                            </button>
                            <button type='button' class='btn btn-outline-purple' onclick='editUser(${response.data.id})'>
                                <i class='mdi mdi-pencil'></i>
                            </button>
                           
                            <button type='button'  name='delete' class="btn btn-outline-danger"onclick="deleteUser(${response.data.id})">
                                <i class="mdi mdi-delete "></i>
                            </button></td>
                                `
                            );
                                }

                            if (response.data.message) {
                                 $('#edit_modal').modal('hide');
                                toastMixin.fire({
                                    icon: 'success',
                                    animation: true,
                                    title: "" + response.data.message + ""
                                });
                                $('.updateemployeeForm')[0].reset();
                            }


                        } else {
                            // html = `<div class="alert alert-danger text-center" role="alert">
                            //         <strong>${response.data.error}</strong>.
                            //     </div>
                            // `;
                            // $('.showError').fadeIn(100).html(html);
                            // $('.showError').fadeOut(5000);
                             toastMixin.fire({
                                    icon: 'error',
                                    animation: true,
                                    title: "" + response.data.error + ""
                                });

                        }

                    }, //success end

                    // beforeSend: function() {
                       
                    //     $('.preloader').empty();
                    //     $('.preloader').addClass('ajax_loader').append(
                    //         `<div class='preloader'>
                    //         <div id="status">
                    //             <div class="spinner"></div>
                    //         </div>
                    //     </div>`
                    //     );
                    // },
                    // complete: function() {
                    //     $('.preloader').removeClass('ajax_loader').empty();
                    // }
                });
            });

        }



        // delete slider
        function deleteUser(id) {
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
                                Swal.fire(
                                    'Deleted!',
                                    "" + response.data.message + "",
                                    'success'
                                )
                                // swal("Done!", response.data.message, "success");
                                $('#userTable').DataTable().row('.user' + response.data.id)
                                    .remove()
                                    .draw();
                            } else {
                                Swal.fire("Error!", "" + response.message + "", "error");
                            }
                        }
                    });

                }
            })


        }
        //end

       

        // check if admin status change
 $(document.body).on('click','.is_admin',function(){
              var id=$(this).attr('data-id');
                if($(this).is(":checked")){


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
                    type: "POST",
                    url: config.routes.is_admin,
                    data: {
                      value:1,
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'JSON',
                    success: function(response) {

                         if (response.success === true) {
                            Swal.fire(
                                'Status Changed!',
                                "" + response.data.message + "",
                                'success'
                            )
                            // swal("Done!", response.data.message, "success");
                              $('.change_role'+response.data.id).text(response.data.role)
                        } else {
                            Swal.fire("Error!", "Can't change status", "error");
                        }
                    }
                });
                }
                else if (
                      /* Read more about handling dismissals below */
                      result.dismiss === Swal.DismissReason.cancel
                    ) {
                  // alert('hi');
                      if ($('.status' + id + "").prop("checked") == true) {
                            // alert('hello')
                            $('.status' + id + "").prop('checked', false);
                        } 
                        else if ($('.status' + id + "").prop("checked") == false) {
                            // alert('sds')
                            $('.status' + id + "").prop('checked', true);
                        }
                    }

                


        })


            }
                 


                else if($(this).is(":not(:checked)")){



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
                    type: "POST",
                    url: config.routes.is_admin,
                    data: {
                      value:0,
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'JSON',
                    success: function(response) {

                         if (response.success === true) {
                            Swal.fire(
                                'Status Changed!',
                                "" + response.data.message + "",
                                'success'
                            )
                            // swal("Done!", response.data.message, "success");
                           $('.change_role'+response.data.id).text(response.data.role)
                        } else {
                            Swal.fire("Error!", "Can't change status", "error");
                        }
                    }
                });
                }
                else if (
                      /* Read more about handling dismissals below */
                      result.dismiss === Swal.DismissReason.cancel
                    ) {
                  // alert('hi');
                      if ($('.status' + id + "").prop("checked") == true) {
                            // alert('hello')
                            $('.status' + id + "").prop('checked', false);
                        } 
                        else if ($('.status' + id + "").prop("checked") == false) {
                            // alert('sds')
                            $('.status' + id + "").prop('checked', true);
                        }
                    }

               


        })



                }
            });
        
    </script>
@endsection
