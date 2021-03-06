@extends('layouts.admin.master')
@section('title')
    Orders In Delivery
@endsection
@section('page-header')
    Orders In Delivery
@endsection
@section('pageCss')
    <style>
        .table>tfoot>tr>td {
            padding: 4px 12px;
        }

        .orderTable tfoot td:first-child {
            font-weight: normal;
        }

        .orderTable tfoot tr:last-child td:first-child {
            font-weight: bold;
        }

        .modal button {
            cursor: pointer;
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
                                    <h4 class="mt-0 header-title">All Orders In Delivery</h4>
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
    <div class="modal addModal fade" id="viewOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="">
                    <h5 class="modal-title text-center">Order Details</h5>
                    <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-3 orderDeta-body">
                    <div class="row">
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="col-12">
                            <h4>Order ID: #<span id="view_order_id"></span></h4>
                            <h4>Customer Name: <span id="view_customer_name"></span></h4>
                            <h4>Customer Email: <span id="view_customer_email"></span></h4>
                            <h4>Customer Contact: <span id="view_customer_contact"></span></h4>
                            <h4>Customer Address: <span id="view_customer_address"></span></h4>
                            <h4>Special Notes: <span id="view_notes"></span></h4>
                        </div>
                        <div class="col-12 mt-3">
                            <h4>Ordered Items</h4>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center orderTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Item Name</th>
                                            <th scope="col">Unit Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="apeend_tbody">

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">Sub Total</td>
                                            <td>Tk <span class="subTotal"></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Vat</td>
                                            <td>Tk <span class="vatAmount"></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Delivery Fee</td>
                                            <td>Tk <span class="deleveryFee"></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Total Amount</td>
                                            <td>Tk <span class="view_total"></span> </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <button data-toggle="modal" data-dismiss="modal" data-target="#orderCancelModal"
                                class="btn-custom dangerBtn mb-3 deny_btn"><img
                                    src="{{ asset('backend/assets/icons/si-glyph_deny.svg') }}" alt="">
                                Deny</button>
                        </div>
                        <div class="col-md-8 text-md-right">
                            <button class="btn-custom btnAccept mb-3 accept_btn"><img
                                    src="{{ asset('backend/assets/icons/icon-park-outline_correct.svg') }}" alt="">
                                Complete</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- view  Modal End -->
    <!-- order deny  Modal -->
    <div class="modal addModal fade" id="orderCancelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="">
                    <h5 class="modal-title text-center">Are you sure you want to cancel?</h5>
                    <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-3 orderCancel-body">
                    <div class="row">
                        <div class="col-12">
                            <h3>Why are you cancelling the order?</h3>
                        </div>
                        <div class="col-12 mb-3">
                            <input type="text" class="form-control"
                                placeholder="The restaurant is busy to serve right now">
                        </div>
                        <div class="col-12 mb-3">
                            <input type="text" class="form-control" placeholder="The delivery address is far away">
                        </div>
                        <div class="col-12 mb-3">
                            <input type="text" class="form-control" placeholder="The special notes can not be fulfilled">
                        </div>
                        <div class="col-12 mb-2">
                            <button class="conformBtn" data-dismiss="modal" id="cancelBtn">Yes, I???m sure about
                                cancelling this
                                order</button>
                        </div>
                        <div class="col-12">
                            <button class="conformBtn cancelBtn orderCancelRedoBtn" data-dismiss="modal">No, I need to think
                                again</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- order deny Modal End -->

    <input type="hidden" name="" id="managerRestaurantId"
    value="{{ Auth::user()->restaurant->restaurant_id }}">
@endsection
@section('pageScripts')
    <script src="{{ asset('backend/assets/js/order.js') }}"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="{{ asset('backend/assets/js/pusher_notification.js') }}"></script>
    <script type='text/javascript'>
        var config = {
            routes: {
                view: "{!! route('manager.order.show') !!}",
                cancelOrder: "{!! route('manager.order.cancel') !!}",
                acceptOrder: "{!! route('manager.order.accept.delivery') !!}",
            }
        };

        $(function() {
            dataTable();
        });

        // function viewOrder(id) {
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         url: config.routes.view,
        //         method: "POST",
        //         data: {
        //             id: id,
        //             // _token: "{{ csrf_token() }}"
        //         },
        //         dataType: "json",
        //         success: function(response) {
        //             if (response.success == true) {
        //                 setOrderDetails(response);
        //                 orderStatus(response.data.order_status_id, response);
        //                 orderItems(response.data.orderItems);
        //                 addBtnToModal(response.data.order_id);
        //                 $('.view_total').html('??? ' + bdCurrencyFormat(response.data.amount));

        //                 if (response.data.delivery_fee != null) {
        //                     $('.deleveryFee').html('??? ' + bdCurrencyFormat(response.data.delivery_fee));
        //                 } else {
        //                     $('.deleveryFee').html('??? ' + 0);
        //                 }
        //                 $('#viewOrderModal').modal('show');

        //             } //success end

        //         },
        //         error: function(error) {
        //             if (error.status == 404) {
        //                 toastMixin.fire({
        //                     icon: 'error',
        //                     animation: true,
        //                     title: "" + 'Data not found' + ""
        //                 });


        //             }
        //         },
        //     }); //ajax end
        // }

        // // set order item 
        // function orderItems(orderItems) {
        //     $('.apeend_tbody').empty();
        //     $.each(orderItems, function(key, val) {
        //         var total_price = two_decimal(val.pivot.quantity * val.pivot.price);
        //         $('.apeend_tbody').append(
        //             `<tr><td class="item_name">${val.name}</td>
        //         <td class="item_price">${'??? ' + bdCurrencyFormat( val.price)}</td>
        //         <td class="item_quantity">${val.pivot.quantity}</td>
        //         <td class="item_total_price">${'??? ' + bdCurrencyFormat(val.pivot.price) }</td></tr>`
        //         );
        //     });
        // }

        // //set order status
        // function orderStatus(order_status_id, response) {
        //     if (order_status_id != null) {
        //         if (response.data.status.name == 'Preparing') {
        //             var class_name = 'primary';
        //         } else if (response.data.status.name == 'Delivering') {
        //             var class_name = 'success';
        //         } else if (response.data.status.name == 'Completed') {
        //             var class_name = 'success';
        //         } else {
        //             var class_name = 'danger';
        //         }
        //         $('#order_status').attr('class', 'btn float-right btn-outline-' + class_name + ' ' +
        //             response.data.class);
        //         $('#order_status').text(response.data.status.name);

        //         if (order_status_id == 4) {
        //             $('.deny_btn').prop('disabled', true);
        //             $('.edit_btn').prop('disabled', true);
        //         } else {
        //             $('.deny_btn').prop('disabled', false);
        //             $('.edit_btn').prop('disabled', false);
        //         }
        //     }


        // }

        // // set button to modal
        // function addBtnToModal(order_id) {
        //     $('.accept_btn').attr('onclick', "acceptOrder(" + order_id + ")")
        //     $('.orderEditBtn').attr('onclick', "openEditModalAction(" + order_id + ")")
        // }

        // //set order details
        // function setOrderDetails(response) {
        //     $('#order_id').val(response.data.order_id);
        //     $('#view_order_id').text(response.data.id);
        //     $('#view_customer_name').text(response.data.is_default_name == 1 ? response.data.name :
        //         response.data.customer.name);
        //     $('#view_customer_contact').text(response.data.is_default_contact == 1 ? response.data
        //         .contact : response.data.customer.contact);
        //     $('#view_customer_address').text(response.data.is_default_address == 1 ? response.data
        //         .address : response.data.customer.address);
        //     $('#view_customer_email').text(response.data.customer.email == null ? "N/A" : response.data.customer.email);
        //     $('#view_notes').text(response.data.special_notes == null ? "N/A" : response.data.special_notes);

        // }

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
                        $("#viewOrderModal").modal("hide");
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
                        $("#orderCancelModal").modal("hide");
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
                                </button>`;
                            // <button type='button' class='btn btn-outline-danger ' onclick='denyOrder(${data})'>
                            //     <i class='fa fa-ban'></i>
                            // </button>`;
                        },
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        }
    </script>
@endsection
