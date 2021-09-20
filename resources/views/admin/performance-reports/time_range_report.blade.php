@extends('layouts.admin.master')
@section('page-header')
    Tiem Range Report
@endsection
@section('restaurant_list')
    @include('layouts.admin.restaurant_drop-down')
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
                                    <h4 class="mt-0 header-title">Time Range Report
                                        <span class="start_date"></span>
                                         <span class="end_date"></span>
                                    </h4>
                                </div>
                                <div class="ms-header-text float-right">
                                    <input type="date" class="form-control date_range" id="start_date">
                                    <input type="date" class="form-control mt-2 date_range" id="end_date">
                                </div>
                            </div>

                            <span class="showError"></span>
                            <div class="table-responsive">
                                <table id="orderTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Order Id</th>
                                            <th>Revenue</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($restaurant->all_orders))
                                            @foreach ($restaurant->all_orders as $order)
                                                <tr class="order{{ $order->order_id }}">
                                                    <td> {{ formatDate($order->created_at) }}</td>
                                                    <td>{{ $order->id }}</td>
                                                    <td><span>৳</span> {{ currency_format($order->amount) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
        
                                        <tr class="table-active">
                                            <td class="col-3 font-weight-bold">Total</td>
                                            <td class="col-3 font-weight-bold">Total Orders <span class="total_orders"></span></td>
                                            <td class="col-3 font-weight-bold ">Total <span class="total_amount"></span></td>
                                        </tr>
    
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->




        </div><!-- container -->

    </div> <!-- Page content Wrapper -->




@endsection
@section('pageScripts')

    <script type='text/javascript'>
        var config = {
            routes: {
                getOrders: "{!! route('order.daily.report.restaurant') !!}",
                getOrdersByRange: "{!! route('order.report.restaurant.date.range') !!}",
            }
        };
        $(document).ready(function() {
            $('#orderTable').DataTable({
                "ordering": false,
            });
        });

// $('start_date').hide();
// $('end_date').hide();


        // restaurant change
        $(document).on('change', '.restaurant', function() {
            var id = $(this).val();
            var end_date = $('#end_date').val();
            var start_date = $('#start_date').val();

            $.ajax({
                type: "POST",
                url: config.routes.getOrdersByRange,
                data: {
                    id: id,
                    start_date: start_date,
                    end_date: end_date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success === true) {
                        $('.restaurant_id').val(response.data.id);
                        $('#orderTable').DataTable().clear().draw();
                        setSessionId(response.data.session_id);
                        $('.start_date').html('- '+response.data.start_date+' -');
                            $('.end_date').html(response.data.end_date);
                        if ($.trim(response.data.orders.all_orders)) {
                            ordersData(response.data.orders.all_orders)
                        }
                        $('.total_orders').html(response.data.total_order);
                        $('.total_amount').html('৳ ' + bdCurrencyFormat(response.data.total_amount));
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


        // get orders by date
        $(".date_range").on("change", function() {
            var end_date = $('#end_date').val();
            var restaurant_id = $('#restaurant_drop_down').val();
            var start_date = $('#start_date').val();

            if (start_date != '' && end_date != '') {
                $.ajax({
                    type: "POST",
                    url: config.routes.getOrdersByRange,
                    data: {
                        id: restaurant_id,
                        start_date: start_date,
                        end_date: end_date,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.success === true) {
                            $('.restaurant_id').val(response.data.id);
                            $('#orderTable').DataTable().clear().draw();
                            setSessionId(response.data.session_id);
                            $('.start_date').html('- '+response.data.start_date+' -');
                            $('.end_date').html(response.data.end_date);
                            $('.total_orders').html(response.data.total_order);
                            $('.total_amount').html('৳ ' + bdCurrencyFormat(response.data.total_amount));
                            if ($.trim(response.data.orders.all_orders)) {
                                ordersData(response.data.orders.all_orders)
                            }


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

        });


        // 
        function ordersData(orders) {
            var orderTable = $('#orderTable').DataTable();
            $.each(orders, function(key, val) {
                var trDOM = orderTable.row.add([
                    "" + val.date + "",
                    "" + val.id + "",
                    "" + '৳ ' + bdCurrencyFormat(val.amount) + "",
                    `   <button type='button' class='btn btn-outline-dark' onclick='viewOrder(${val.order_id})'>
                                                <i class='fa fa-eye'></i>
                                            </button>`
                ]).draw().node();
                $(trDOM).addClass('order' + val.order_id + '');
            });

        }
    </script>
@endsection
