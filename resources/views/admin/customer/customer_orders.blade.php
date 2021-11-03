@extends('layouts.admin.master')
@section('page-header')
   {{$customer->name}} - Orders List
@endsection
@section('restaurant_list')
    @include('layouts.admin.restaurant_drop-down')
@endsection
@section('pageCss')
    <style>
        .txt-preparing {
            color: rgb(38, 38, 160);
            font-weight: 600;
        }

        .txt-cancelled {
            color: rgb(255, 0, 0);
            font-weight: 600;
        }

        .txt-delivering {
            color: rgb(189, 179, 45);
            font-weight: 600;
        }

        .txt-completed {
            color: rgb(6, 78, 4);
            font-weight: 600;
        }

        .view-modal p {
            line-height: 2;
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
                                    <h4 class="mt-0 header-title">All Past Orders</h4>
                                </div>
                            </div>
                            <input type="hidden" name="" id="customer_id" value="{{$customer->customer_id}}">
                            <div class="table-responsive">
                                <table id="orderTable" class="table table-bordered dt-responsive nowrap data-table"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Date</th>
                                            <th>Customer Name</th>
                                            <th>Customer Contact</th>
                                            <th>Customer Address</th>
                                            <th>Total Revenue</th>
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
                            {{-- <button class="float-right">sadasdas</button> --}}
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

                        <div class="col-md-12">
                            <button data-dismiss="modal" class="btn btn-block btn-custom btnAccept mb-3 accept_btn"> Done</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- view  Modal End -->
@endsection
@section('pageScripts')
    <script type='text/javascript'>
        var config = {
            routes: {
                view: "{!! route('order.show') !!}",
                getOrders: "{!! route('customer.order.restaurant') !!}",
            }
        };

        $('.user_li').addClass('nav-active');
        $('.customer_li').addClass('active');

    $(function () {
    var id = $('#customer_id').val();
    var url = '{{ route("customer.orders", ":id") }}';
    url = url.replace(':id', id);
    var table = $('.data-table').DataTable({
        // processing: true,
        serverSide: true,
        ajax: url,
        columns: [
            {data: 'orderID'},
            {data: 'date'},
            {data: 'customer_name'},
            {data: 'customer_contact'},
            {data: 'customer_address'},
            {data: 'amount'},
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
         // view single 
         function viewOrder(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: config.routes.view,
                method: "POST",
                data: {
                    id: id,
                    // _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        setOrderDetails(response);
                        orderStatus(response.data.order_status_id, response);
                        orderItems(response.data.orderItems);
                        $('.view_total').html('৳ ' + bdCurrencyFormat(response.data.amount));
                        if (response.data.delivery_fee != null) {
                            $('.deleveryFee').html('৳ ' + bdCurrencyFormat(response.data.delivery_fee));
                        } else {
                            $('.deleveryFee').html('৳ ' + 0);
                        }
                        $('#viewOrderModal').modal('show');

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

        function setOrderDetails(response) {
            $('#order_id').val(response.data.order_id);
            $('#view_order_id').text(response.data.id);
            $('#view_customer_name').text(response.data.is_default_name == 1 ? response.data.name :
                response.data.customer.name);
            $('#view_customer_contact').text(response.data.is_default_contact == 1 ? response.data
                .contact : response.data.customer.contact);
            $('#view_customer_address').text(response.data.is_default_address == 1 ? response.data
                .address : response.data.customer.address);
            $('#view_customer_email').text(response.data.customer.email == null ? "N/A" : response.data.customer.email);
            $('#view_notes').text(response.data.special_notes == null ? "N/A" : response.data.special_notes);

        }
        // set order item 
        function orderItems(orderItems) {
            $('.apeend_tbody').empty();
            $.each(orderItems, function(key, val) {
                var total_price = two_decimal(val.pivot.quantity * val.pivot.price);
                $('.apeend_tbody').append(
                    `<tr><td class="item_name">${val.name}</td>
                <td class="item_price">${'৳ ' + bdCurrencyFormat( val.price)}</td>
                <td class="item_quantity">${val.pivot.quantity}</td>
                <td class="item_total_price">${'৳ ' + bdCurrencyFormat(val.pivot.price) }</td></tr>`
                );
            });
        }

        //set order status
        function orderStatus(order_status_id, response) {
            if (order_status_id != null) {
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

                if (order_status_id == 4) {
                    $('.deny_btn').prop('disabled', true);
                    $('.edit_btn').prop('disabled', true);
                } else {
                    $('.deny_btn').prop('disabled', false);
                    $('.edit_btn').prop('disabled', false);
                }
            }


        }

        // restaurant change
        $(document).on('click', '.restaurant', function() {
            var id = $(this).data('id');
            var customer_id = $('#customer_id').val();
            $.ajax({
                type: "POST",
                url: config.routes.getOrders,
                data: {
                    id: id,
                    customer_id: customer_id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success === true) {
                        $('.restaurant_id').val(response.data.id);
                        $('#orderTable').DataTable().clear().destroy();
                        setSessionId(response.data.session_id); // set restaurant id into session
                        setRestaurant(response.data.restaurant_name, response.data.id); // set restaurant into topbar        
                        dataTable();

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

    function dataTable(){
        var url = '{{ route("customer.order") }}';
        var table = $('.data-table').DataTable({
        serverSide: true,
        ajax: url,
        columns: [
            {data: 'orderID'},
            {data: 'date'},
            {data: 'customer_name'},
            {data: 'customer_contact'},
            {data: 'customer_address'},
            {data: 'amount'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    }    
    </script>
@endsection
