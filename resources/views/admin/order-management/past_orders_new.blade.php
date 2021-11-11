@extends('layouts.admin.master')
@section('page-header')
    Past Orders
@endsection
@section('restaurant_list')
    @include('layouts.admin.restaurant_drop-down')
@endsection
@section('pageCss')
    <style>


        .view-modal p {
            line-height: 2;
        }

        .order-status-btn {
            font-weight: bold;
            font-size: 18px;
            line-height: 24px;
            text-transform: capitalize;
            border-radius: 5px;
            border: 0;
            background: transparent;
            padding: 5px 30px;
            display: inline-block;
        }

        .order-status-btn.preparing {
            border: 2px solid #153289;
            color: #153289;
        }

        .order-status-btn.cancelled {
            border: 2px solid #ff0000;
            color: #ff0000;
        }

        .order-status-btn.delivering {
            border: 2px solid #b4ad06;
            color: #b4ad06;
        }

        .order-status-btn.completed {
            border: 2px solid #176a2d;
            color: #176a2d;
        }

        .order-status-btn.pending {
            border: 2px solid #DE973D;
            color: #DE973D;
        }

        .table>tfoot>tr>td {
            padding: 4px 12px;
        }

        .orderTable tfoot td:first-child {
            font-weight: normal;
        }

        .orderTable tfoot tr:last-child td:first-child {
            font-weight: bold;
        }

        td .cancelled {
            color: #ff0000;
        }

        .pending {
            font-weight: 600;
            color: #DE973D;
        }

        .completed {
            color: #176a2d;
            font-weight: 600;
        }

        .cancelled {
            color: #ff0000;
            font-weight: 600;
        }

        .preparing {
            color: #153289;
            font-weight: 600;
        }

        .delivering {
            color: #b4ad06;
            font-weight: 600;
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
                            <div class="row pb-5">
                                <div class="col-lg-4">
                                    <h4 class="mt-0 header-title">All Past Orders</h4>
                                </div>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-10">
                                        </div>
                                        <div class="col-lg-2 pr-0">
                                            <div class="dropdown">
                                                <button class="custom-select downloadDropDown" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <img src="{{ asset('backend/assets/icons/download-icon.svg') }}"
                                                        alt="">
                                                </button>
                                                <div class="dropdown-menu downloadMenu"
                                                    aria-labelledby="dropdownMenuButton">
                                                    <button onclick="downloadPdf()"><img
                                                            src="{{ asset('backend/assets/icons/pdf-icon.svg') }}" alt="">
                                                        PDF
                                                        File</button>
                                                    <button onclick="downloadCsv()"><img
                                                            src="{{ asset('backend/assets/icons/csv-icon.svg') }}" alt="">
                                                        CSV
                                                        File</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="orderTable" class="table table-bordered dt-responsive nowrap data-table"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Customer Name</th>
                                            <th>Customer Contact</th>
                                            <th>Customer Address</th>
                                            <th>Total Revenue</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @if (!empty($restaurant->restaurant_orders))
                                            @foreach ($restaurant->restaurant_orders as $order)
                                                <tr class="order{{ $order->order_id }}">
                                                    <td>{{ $order->id }}</td>
                                                    <td> {{formatDate($order->created_at)}}</td>
                                                    <td class="{{(($order->status->name == 'Preparing') ? 'txt-preparing'
                                                        :(($order->status->name == 'Delivering') ? 'txt-delivering' : (($order->status->name == 'Completed') ? 'txt-completed' : 'txt-cancelled'  )))}}">{{ $order->status->name }}</td>
                                                    <td>{{ $order->is_default_name == 0 ? $order->name : $order->customer->name }}
                                                    </td>
                                                    <td>{{ $order->is_default_contact == 0 ? $order->contact : $order->customer->contact }}
                                                    </td>
                                                    <td>{{ $order->is_default_address == 0 ? $order->address : $order->customer->address }}
                                                    </td>
                                                    <td><span>৳</span> {{ currency_format($order->amount) }}</td>

                                                    <td>
                                                        <button type='button' class='btn btn-outline-dark'
                                                            onclick='viewOrder({{ $order->order_id }})'><i
                                                                class='fa fa-eye'></i></button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif --}}
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
    {{-- <div class="modal addModal fade" id="viewOrderModal" tabindex="-1" aria-hidden="true">
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

                        <div class="col-md-12">
                            <button data-dismiss="modal" class="btn btn-block btn-custom btnAccept mb-3 accept_btn"> Done</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


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
                        <div class="col-12">
                            <div class="row">
                                <input type="hidden" name="order_id" id="order_id">
                                <div class="col-12 col-md-9">
                                    <h4>Order ID: #<span id="view_order_id"></span></h4>
                                    <h4>Customer Name: <span id="view_customer_name"></span></h4>
                                    <h4>Customer Email: <span id="view_customer_email"></span></h4>
                                    <h4>Customer Contact: <span id="view_customer_contact"></span></h4>
                                    <h4>Customer Address: <span id="view_customer_address"></span></h4>
                                    <h4>Special Notes: <span id="view_notes"></span></h4>
                                </div>
                                <div class="col-12 col-md-3 text-right align-self-end">
                                    <button id="orderStatusBtn" class="order-status-btn text-center "></button>
                                </div>
                            </div>
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
                                            <td>Tk <span class="view_total">1,500</span> </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12 ">
                            <button data-dismiss="modal" class="btn-custom btnAccept btn-block mt-2">Done</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- view  Modal End -->
    @include('layouts.admin.restaurant_add_modal')
@endsection
@section('pageScripts')
    <script type='text/javascript'>
        CKEDITOR.replace('restaurant_description');
        var config = {
            routes: {
                view: "{!! route('order.show') !!}",
                getOrders: "{!! route('order.past.restaurant') !!}",
            }
        };


        $(function() {
            $('.orders').addClass('sub-nav-active');
            $('.orders a').siblings("ul").toggle().removeClass("d-none");
            $('.orders a')
                .children("span")
                .children("span")
                .children(".mdi")
                .css("transform", "rotate(0deg)");
            $('.restaurant_li').addClass('nav-active');
            dataTable();
        });

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
                        $('.view_total').html(bdCurrencyFormat(response.data.amount));
                        $('.subTotal').html(bdCurrencyFormat(response.data.sutTotal));
                        $('.vatAmount').html(bdCurrencyFormat(response.data.vat_amount ?? 0));
                        if (response.data.delivery_fee != null) {
                            $('.deleveryFee').html(bdCurrencyFormat(response.data.delivery_fee));
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
                <td class="item_price">${'TK ' + bdCurrencyFormat( val.price)}</td>
                <td class="item_quantity">${val.pivot.quantity}</td>
                <td class="item_total_price">${'TK ' + bdCurrencyFormat(val.pivot.price) }</td></tr>`
                );
            });
        }

        //set order status
        function orderStatus(order_status_id, response) {
            if (order_status_id != null) {
                if (response.data.status.name == 'Preparing') {
                    var class_name = 'preparing';
                } else if (response.data.status.name == 'Delivering') {
                    var class_name = 'delivering';
                } else if (response.data.status.name == 'Completed') {
                    var class_name = 'completed';
                } else {
                    var class_name = 'cancelled';
                }
                $('.order-status-btn').html(response.data.status.name);
            } else {
                $('.order-status-btn').html('Pending');
                var class_name = 'pending';
            }
            $('#orderStatusBtn').removeClass();
            $('#orderStatusBtn').addClass('order-status-btn text-center ' + class_name);

        }

        // restaurant change
        $(document).on('click', '.restaurant', function() {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: config.routes.getOrders,
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success === true) {
                        $('.restaurant_id').val(response.data.id);
                        $('#orderTable').DataTable().clear().destroy();
                        setSessionId(response.data.session_id); // set restaurant id into session
                        setRestaurant(response.data.restaurant_name, response.data
                        .id); // set restaurant into topbar
                        // if ($.trim(response.data.orders)) {
                        //     var orderTable = $('#orderTable').DataTable();
                        //     $.each(response.data.orders, function(key, val) {
                        //         var trDOM = orderTable.row.add([
                        //             "" + val.id + "",
                        //             "" + response.data.date + "",
                        //             "" + val.status.name + "",
                        //             "" + val.is_default_name == 0 ? val.name : val
                        //             .customer.name + "",
                        //             "" + val.is_default_contact == 0 ? val.contact : val
                        //             .customer.contact + "",
                        //             "" + val.is_default_address == 0 ? val.address : val
                        //             .customer.address + "",
                        //             "" + val.amount + "",
                        //             `   <button type='button' class='btn btn-outline-dark' onclick='viewOrder(${val.order_id})'>
                    //                         <i class='fa fa-eye'></i>
                    //                     </button>`
                        //         ]).draw().node();
                        //         $(trDOM).addClass('order' + val.order_id + '');
                        //     });
                        // }

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

        function dataTable() {
            var id = $('#restaurantId').val();
            var url = '{{ route('orders.past', ':id') }}';
            url = url.replace(':id', id);
            var d = new Date();
            var table = $('.data-table').DataTable({
                // processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csvHtml5',
                        titleAttr: 'CSV File',
                        filename: 'past orders',
                        className: 'd-none',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6],
                            charSet: "utf-8",
                        },
                        customizeData: function(data) {
                            var ind = data.header.indexOf(
                                "Phone"
                                ); // This code is to find the column name's index which you want to cast.
                            for (var i = 0; i < data.body.length; i++) {
                                data.body[i][ind] = '\u200C' + data.body[i][
                                    ind
                                ]; //will cast the number to string.
                            }
                        },
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Past Orders',
                        filename: 'past orders',
                        className: 'd-none',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6],
                        },
                    },

                ],
                ajax: url,
                "columnDefs": [{
                    "targets": [2],
                    "createdCell": function(td, cellData, rowData, row, col) {
                        switch (cellData) {
                            case "Pending":
                                $(td).addClass('pending');
                                break;
                            case "Completed":
                                $(td).addClass('completed');
                                break;
                            case "Cancelled":
                                $(td).addClass('cancelled');
                                break;
                            case "Delivering":
                                $(td).addClass('delivering');
                                break;
                            case "Preparing":
                                $(td).addClass('preparing');
                                break;
                        }
                    }
                }],
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'order_date'
                    },
                    {
                        // class: (status == 'Delivering') ? 'delivering' : (status == 'Completed') ? 'completed': (status == 'Preparing') ? 'preparing': (status == 'Cancelled') ? 'cancelled' : 'pending' ,
                        class: `${status}`,
                        data: 'status',
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
                        data: 'amount'
                    },
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
