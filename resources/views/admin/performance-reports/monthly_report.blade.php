@extends('layouts.admin.master')
@section('page-header')
    Daily Report
@endsection
@section('restaurant_list')
    {{-- @include('layouts.admin.restaurant_drop-down') --}}
@endsection
@section('pageCss')
    <style>


    </style>
@endsection
@section('content')
    <div class="preloader"></div>

    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-4">
                                <div class="ms-header-text">
                                    <h4 class="mt-0 header-title">Daily Report <span
                                            class="current_date"></span></h4>
                                </div>
                                <div class="ms-header-text float-right">
                                    <input type="date" class="form-control" id="datepicker">
                                    {{-- <input type="text" class="form-control" id="datepicker"/> --}}
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
                getOrdersByDate: "{!! route('order.daily.report.restaurant.date') !!}",
            }
        };
        $(document).ready(function() {
            $('#orderTable').DataTable({
                "ordering": false,
            });
        });



        // restaurant change
        $(document).on('change', '.restaurant', function() {
            var id = $(this).val();
            var date = $('#datepicker').val();
            $.ajax({
                type: "POST",
                url: config.routes.getOrdersByDate,
                data: {
                    id: id,
                    date: date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success === true) {
                        $('.restaurant_id').val(response.data.id);
                        $('#orderTable').DataTable().clear().draw();
                        setSessionId(response.data.session_id);
                        $('.current_date').html(response.data.current_date);
                        if($.trim(response.data.orders.all_orders) ){
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
        });


        // get orders by date
        $("#datepicker").on("change", function() {
            var date = $(this).val();
            var restaurant_id = $('#restaurant_drop_down').val();
            $.ajax({
                type: "POST",
                url: config.routes.getOrdersByDate,
                data: {
                    id: restaurant_id,
                    date: date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success === true) {
                        $('.restaurant_id').val(response.data.id);
                        $('#orderTable').DataTable().clear().draw();
                        setSessionId(response.data.session_id);
                        $('.current_date').html(response.data.current_date);
                        if($.trim(response.data.orders.all_orders) ){
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
