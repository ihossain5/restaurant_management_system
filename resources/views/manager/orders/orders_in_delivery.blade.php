@extends('layouts.admin.master')
@section('page-header')
    New Orders
@endsection


@section('pageCss')
    <style>
        .accept_btn {
            padding: 3px 20px;
            font-weight: 600;
            border-radius: 5px;
        }

        .edit_btn {
            padding: 3px 30px;
            font-weight: 600;
            border-radius: 5px;
        }

        .deny_btn {
            padding: 3px 30px;
            font-weight: 600;
            border-radius: 5px;
        }

        .deny-modal-footer {
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
                                    <h4 class="mt-0 header-title">All New Orders</h4>
                                </div>
                            </div>

                            <span class="showError"></span>
                            <div class="table-responsive">
                                <table id="orderTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Customer Name</th>
                                            <th>Customer Contact</th>
                                            <th>Customer Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->




        </div><!-- container -->

    </div> <!-- Page content Wrapper -->



    <!-- view  Modal -->
    <div class="modal fade bs-example-modal-center" id="viewModal" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header d-block">
                    <h5 class="modal-title mt-0 text-center">Order Details</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 col-md-12">
                        <div class="ms-form-group view-modal">
                            <input type="hidden" name="" id="order_id" value="">
                            <p>
                                <strong>Order ID:</strong> <span id="view_order_id"></span>
                            </p>
                            <p>
                                <strong>Customer Name:</strong> <span id="view_customer_name"></span>
                            </p>
                            <p>
                                <strong>Customer Email:</strong> <span id="view_customer_email"></span>
                            </p>
                            <p>
                                <strong>Customer Contact:</strong> <span id="view_customer_contact"></span>
                            </p>
                            <p>
                                <strong>Customer Address :</strong> <span id="view_customer_address"></span>
                            </p>
                            <p>
                                <strong>Special Notes :</strong> <span id="view_notes"></span>
                            </p>
                        </div>

                    </div>
                    <div class="row p-3">
                        <div class="table-responsive">
                            <h5 class="text-center">Order Items</h5>
                            <table class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody class="apeend_tbody">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="col-3 test">Delevery Fee</td>
                                        <td class="col-3 test"></td>
                                        <th class="col-3"></th>
                                        <td class="col-3 deleveryFee">asdasd </td>
                                    </tr>
                                    <tr class="table-active">
                                        <td class="col-3 font-weight-bold">Total Amount</td>
                                        <td class="col-3 test"></td>
                                        <th class="col-3"></th>
                                        <td class="col-3 view_total"> </td>
                                    </tr>

                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer view-modal-footer">
                    <button type="submit" class="btn btn-success accept_btn waves-effect waves-light text-dark">
                        <i class="fa fa-check"></i> Complete
                    </button>
                    <button type="button" data-dismiss="modal"
                        class="btn btn-danger deny_btn waves-effect waves-light text-dark">
                        <i class="fa fa-ban"></i> Deny
                    </button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- view  Modal End -->
    <!-- order deny  Modal -->
    <div class="modal fade bs-example-modal-center" id="orderDenyModal" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header d-block">
                    <h5 class="modal-title mt-0 text-center">Are you sue you want to cancel?</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer deny-modal-footer">
                    <button id="editBtn" type="button" class="btn btn-block btn-danger waves-effect waves-light">
                        Yes, I'm sure about the cancelling this order
                    </button>
                    <button type="button" data-dismiss="modal" class="btn btn-block btn-secondary waves-effect waves-light">
                        No, I need to think again
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- order deny Modal End -->
@endsection
@section('pageScripts')
    <script src="{{ asset('backend/assets/js/order.js') }}"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="{{asset('backend/assets/js/pusher_notification.js')}}"></script>
    <script type='text/javascript'>
        var config = {
            routes: {
                view: "{!! route('order.show') !!}",
                cancelOrder: "{!! route('manager.order.cancel') !!}",
                acceptOrder: "{!! route('manager.order.accept.delivery') !!}",
            }
        };

        $(function() {
            dataTable();
        });

        // view single 
        function viewOrder(id) {
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
                        $('#order_id').val(response.data.order_id);
                        $('#view_order_id').text(response.data.id);
                        $('#view_customer_name').text(response.data.is_default_name == 0 ? response.data.name :
                            response.data.customer.name);
                        $('#view_customer_contact').text(response.data.is_default_contact == 0 ? response.data
                            .contact : response.data.customer.contact);
                        $('#view_customer_address').text(response.data.is_default_address == 0 ? response.data
                            .address : response.data.customer.address);
                        $('#view_customer_email').text(response.data.customer.email ?? 'N/A');
                        $('#view_notes').text(response.data.special_notes ?? 'N/A');

                        if(response.data.order_status_id == 4){
                            $('.deny_btn').prop('disabled',true);
                            $('.edit_btn').prop('disabled',true);
                        }else{
                            $('.deny_btn').prop('disabled',false);
                            $('.edit_btn').prop('disabled',false);
                        }
                        $('.accept_btn').attr('onclick', "acceptOrder(" + response.data.order_id + ")")

                        if (response.data.status.name == 'Preparing') {
                            var class_name = 'primary';
                        } else if (response.data.status.name == 'Delivering') {
                            var class_name = 'success';
                        } else if (response.data.status.name == 'Completed') {
                            var class_name = 'success';
                        } else {
                            var class_name = 'danger';
                        }

                        $('#order_status').attr('class', 'btn float-right btn-outline-' + class_name + ' ' +
                            response.data.class);
                        $('#order_status').text(response.data.status.name);

                        $('.apeend_tbody').empty();
                        $.each(response.data.items, function(key, val) {
                            var total_price = two_decimal(val.pivot.quantity * val.pivot.price);
                            $('.apeend_tbody').append(
                                `<tr><td class="item_name">${val.name}</td>
                                <td class="item_price">${'৳ ' + bdCurrencyFormat( val.pivot.price)}</td>
                                <td class="item_quantity">${val.pivot.quantity}</td>
                                <td class="item_total_price">${'৳ ' + bdCurrencyFormat(total_price) }</td></tr>`
                            );

                        });
                        $('.view_total').html('৳ ' + bdCurrencyFormat(response.data.amount));
                        if (response.data.delivery_fee != null) {
                            $('.deleveryFee').html('৳ ' + bdCurrencyFormat(response.data.delivery_fee));
                        } else {
                            $('.deleveryFee').html('৳ ' + 0);
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

        function acceptOrder(id) {
            $.ajax({
                type: "POST",
                url: config.routes.acceptOrder,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success === true) {
                        var table = $('#orderTable').DataTable();
                        $(".completed_order_badge").html(response.data.completed_order);
                        $(".delivery_order_badge").html(response.data.order_in_delivary);
                        $("#viewModal").modal("hide");
                        table.row().clear().destroy();
                        dataTable();
                        toastMixin.fire({
                            icon: "success",
                            animation: true,
                            title: response.data.message,
                        });
                    }
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastMixin.fire({
                            icon: "error",
                            animation: true,
                            title: "" + "Data not found" + "",
                        });
                    }
                },
            });
        }    

        function cancelOrder(id) {
            $.ajax({
                type: "POST",
                url: config.routes.cancelOrder,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                },
                dataType: "JSON",

                success: function(response) {
                    if (response.success === true) {
                        var table = $('#orderTable').DataTable();
                        $(".cancel_order_badge").html(response.data.cancel_order);
                        $(".delivery_order_badge").html(response.data.order_in_delivery);
                        $("#orderDenyModal").modal("hide");
                        table.row().clear().destroy();
                        dataTable();
                        toastMixin.fire({
                            icon: "success",
                            animation: true,
                            title: response.data.message,
                        });
                    }
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastMixin.fire({
                            icon: "error",
                            animation: true,
                            title: "" + "Data not found" + "",
                        });
                    }
                },
            });
        }

        function dataTable() {
            var table = $('#orderTable').DataTable({
                // processing: true,
                serverSide: true,
                ajax: '{{ route('manager.order.in.delivery') }}',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'customer_name'
                    },
                    {
                        data: 'customer_contact'
                    },
                    {
                        data: 'customer_adress'
                    },
                    {
                        data: 'action',
                        render: function(data, type, full, meta) {
                            return `<button type='button' class='btn btn-outline-dark' onclick='viewOrder(${data})'>
                                <i class='fa fa-eye'></i>
                                </button>
                                <button type='button' class='btn btn-outline-success'>
                                    <i class='fa fa-eye'></i>
                                </button>
                                <button type='button' class='btn btn-outline-danger ' onclick='denyOrder(${data})'>
                                    <i class='fa fa-ban'></i>
                                </button>`;
                        },
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        }
    </script>
@endsection
