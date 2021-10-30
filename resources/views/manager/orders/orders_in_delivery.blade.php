@extends('layouts.admin.master')
@section('title')
    Orders In Delivery
@endsection
@section('page-header')
    Orders In Delivery
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
                                            <td>Total Amount</td>
                                            <td></td>
                                            <td></td>
                                            <td class="view_total"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-4">
                          
                        </div>
                        <div class="col-md-8 text-md-right">
                            <button class="btn-custom btnAccept mb-3 accept_btn"><img
                                    src="{{asset('backend/assets/icons/icon-park-outline_correct.svg')}}" alt=""> Complete</button>
                            <button data-toggle="modal" data-dismiss="modal" data-target="#orderCancelModal"
                                    class="btn-custom dangerBtn mb-3 deny_btn"><img src="{{asset('backend/assets/icons/si-glyph_deny.svg')}}" alt="">
                                    Deny</button>
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
                            <input type="text" class="form-control"
                                placeholder="The special notes can not be fulfilled">
                        </div>
                        <div class="col-12 mb-2">
                            <button class="conformBtn" data-dismiss="modal" id="cancelBtn">Yes, I’m sure about cancelling this
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
@endsection
@section('pageScripts')
    <script src="{{ asset('backend/assets/js/order.js') }}"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="{{asset('backend/assets/js/pusher_notification.js')}}"></script>
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
