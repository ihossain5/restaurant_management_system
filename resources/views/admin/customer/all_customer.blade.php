@extends('layouts.admin.master')
@section('page-header')
    Customers
@endsection

@section('pageCss')
    <style>
        #view_image{
            width: 100%;
        }
        .ban-btn i{
            font-size: 20px;
        }

        .btn-outline-info svg{
           /* width: 25px; */
           height: 20px;
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
                                    <h4 class="mt-0 header-title">All Customers</h4>
                                </div>
                            </div>
                            <table id="customerTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Default Address </th>
                                        <th>Ban Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->




        </div><!-- container -->

    </div> <!-- Page content Wrapper -->


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
                                <strong>Gender:</strong> <span id="view_gender"></span><br>
                                <strong>Email:</strong> <span id="view_email"></span><br>
                                <strong>Phone:</strong> <span id="view_phone"></span><br>
                                <strong>Default Address:</strong> <span id="view_address"></span><br>
                                <label for="name"><strong>Photo:</strong></label> <br>
                            <img src="" id="view_image">
                            </p>
                        </div>
                        <div class="form-group">
                            <div>
                               

                            </div>
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
                view: "{!! route('customer.show') !!}",
                banned: "{!! route('customer.banned') !!}",
            }
        };



        var imagesUrl = '{!! URL::asset('/images/') !!}';
        $(document).ready(function() {
            var url = '{{ route('customer.index') }}';
            var table = $('#customerTable').DataTable({
                // processing: true,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csvHtml5',
                        text: '<img src="{{ asset('backend/assets/icons/pdf-icon.svg') }}" alt=""> CSV File',
                        titleAttr: 'CSV File',
                        className: 'downloadMenu',
                    },
                    'pdfHtml5'
                ],
                serverSide: true,
                ajax: url,
                columns: [
                    {data: 'image',
                    render: function( data, type, full, meta ) {
                        return "<img src=\"/images/"+data+"\" height=\"50\"/>";
                    }
                    },
                    {data: 'name'},
                    {data: 'sex'},
                    {data: 'email'},
                    {data: 'contact'},
                    {data: 'address'},
                    {data: 'status',
                    name: 'status', 
                orderable: true, 
                searchable: true
                    },
                    {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
                ]
            });


        });






        // view single 
        function viewCustomer(id) {
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
                        $('#view_email').text(response.data.email);
                        $('#view_gender').text(response.data.sex ?? 'N/A');
                        $('#view_phone').text(response.data.contact ?? 'N/A');
                        $('#view_address').text(response.data.address ?? 'N/A');

                        if (response.data.photo === null) {
                            $('#view_image').attr('src','/images/default.png');
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



        // delete 
        function bannedCustomer(id) {
            // alert(id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: config.routes.banned,
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
                            }
                        },
                        error: function(error) {
                            if (error.status == 404) {
                                toastMixin.fire({
                                    icon: 'error',
                                    animation: true,
                                    title: "" + 'Customer not found' + ""
                                });


                            }
                        },
                    });

                }else {
                    if ($('.status' + id + "").prop("checked") == true) {
                        $('.status' + id + "").prop('checked', false);
                    } else {
                        $('.status' + id + "").prop('checked', true);
                    }
                }
            })


        }
        //end
    </script>
@endsection
