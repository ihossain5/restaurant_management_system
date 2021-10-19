@extends('layouts.admin.master')
@section('page-header')
    Today's Order
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
                                    <h4 class="mt-0 header-title">All Today's Order</h4>
                                </div>
                            </div>

                            <span class="showError"></span>
                            <div class="table-responsive">
                                <table id="orderTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Status</th>
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
                            <p class="pb-3">
                                <strong>Order ID:</strong> <span id="view_order_id"></span><br>
                                <strong>Customer Name:</strong> <span id="view_customer_name"></span><br>
                                <strong>Customer Email:</strong> <span id="view_customer_email"></span><br>
                                <strong>Customer Contact:</strong> <span id="view_customer_contact"></span><br>
                                <button type="button" class="btn btn-outline-purple float-right waves-effect waves-light"
                                    name="button" id="order_status">
                                </button>
                                <strong>Customer Address :</strong> <span id="view_customer_address"></span><br>
                                <strong>Special Notes :</strong> <span id="view_notes"></span><br>
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
                view: "{!! route('order.show') !!}",
                getOrders: "{!! route('order.restaurant') !!}",
            }
        };

    $(function () {
        $('.restaurant_li').addClass('nav-active');
        // $('.order_li').addClass('sub-nav-active');
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
                        $('#view_order_id').text(response.data.id);
                        $('#view_customer_name').text(response.data.is_default_name == 0 ? response.data.name :
                            response.data.customer.name);
                        $('#view_customer_contact').text(response.data.is_default_contact == 0 ? response.data
                            .contact : response.data.customer.contact);
                        $('#view_customer_address').text(response.data.is_default_address == 0 ? response.data
                            .address : response.data.customer.address);
                        $('#view_customer_email').text(response.data.customer.email ?? 'N/A');
                        $('#view_notes').text(response.data.special_notes ?? 'N/A');

                        if(response.data.order_status_id !== ''){
                            if (response.data.status.name == 'Preparing') {
                            var class_name = 'primary';
                        } else if (response.data.status.name == 'Delivering') {
                            var class_name = 'success';
                        } else if (response.data.status.name == 'Completed') {
                            var class_name = 'success';
                        } else {
                            var class_name = 'danger';
                        }
                        }else{
                            alert('asdasd');
                            var class_name = 'none';
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
                        if(response.data.delivery_fee != null){
                            $('.deleveryFee').html('৳ ' + bdCurrencyFormat(response.data.delivery_fee));
                        }else{
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
    var id = $('#restaurantId').val();
    var url = '{{ route("today.order.restaurant", ":id") }}';
    url = url.replace(':id', id);
    var table = $('#orderTable').DataTable({
        // processing: true,
        serverSide: true,
        ajax: url,
        columns: [
            {data: 'id'},
            { 
                // class: (status.name == 'Delivering') ? 'txt-delivering' : (status.name == 'Completed') ? 'txt-completed': (status.name == 'Preparing') ? 'txt-preparing': 'txt-cancelled',
                data: 'status.name'
            },
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
