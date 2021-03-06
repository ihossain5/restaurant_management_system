@extends('layouts.admin.master')
@section('page-header')
    Daily Report
@endsection
@section('restaurant_list')
    @include('layouts.admin.restaurant_drop-down')
@endsection
@section('pageCss')
    <style></style>
@endsection
@section('content')
    <div class="preloader"></div>
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row pb-5">
                                <div class="col-lg-4">
                                    <h4 class="mt-0 header-title">Daily Report -<span
                                        class="current_date">{{ $current_date }}</span></h4>
                                </div>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6">
                                        </div> 
                                        <div class="col-lg-2 pr-0">
                                            <div class="dropdown">
                                                <button class="custom-select downloadDropDown" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <img src="{{asset('backend/assets/icons/download-icon.svg')}}" alt="">
                                                </button>
                                                <div class="dropdown-menu downloadMenu"
                                                    aria-labelledby="dropdownMenuButton">
                                                    <button><img src="{{asset('backend/assets/icons/pdf-icon.svg')}}" alt=""> PDF
                                                        File</button>
                                                    <button><img src="{{asset('backend/assets/icons/csv-icon.svg')}}" alt=""> CSV
                                                        File</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="custom-date">
                                                <div class="input-daterange input-group" >
                                                    <div class="customDatePicker w-100"
                                                        style="max-width: none;">
                                                        <img src="{{asset('backend/assets/icons/dateicon.svg')}}" alt="">
                                                        <input type="text" class="form-control" id="datepicker"
                                                            name="fullDate" placeholder="Select Date"/>
                                                        <img src="{{asset('backend/assets/icons/color-arrow-down.svg')}}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
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
                                        @if (!empty($restaurant->restaurant_orders))
                                            @foreach ($restaurant->restaurant_orders as $order)
                                                <tr class="order{{ $order->order_id }}">
                                                    <td> {{ formatDate($order->created_at) }}</td>
                                                    <td>{{ $order->id }}</td>
                                                    <td><span>???</span> {{ currency_format($order->amount) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        @include('layouts.admin.table_footer_order_total')
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container -->
    </div> <!-- Page content Wrapper -->
    @include('layouts.admin.restaurant_add_modal')
@endsection
@section('pageScripts')
    <script type='text/javascript'>
     CKEDITOR.replace('restaurant_description');
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
        $(document).on('click', '.restaurant', function() {
            var id = $(this).data('id');
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
                        setSessionId(response.data.session_id); // set restaurant id into session
                        setRestaurant(response.data.restaurant_name, response.data.id); // set restaurant into topbar
                        $('.total_orders').html(response.data.total_order);
                        $('.total_amount').html('??? ' + bdCurrencyFormat(response.data.total_amount));
                        $('.current_date').html(response.data.current_date);
                        if($.trim(response.data.orders) ){
                            ordersData(response.data.orders)
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
            var restaurant_id = $('#restaurantId').val();
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
                        $('.total_orders').html(response.data.total_order);
                        $('.total_amount').html('??? ' + bdCurrencyFormat(response.data.total_amount));
                        if($.trim(response.data.orders) ){
                            ordersData(response.data.orders)
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
                    "" + '??? ' + bdCurrencyFormat(val.amount) + "",
                    `   <button type='button' class='btn btn-outline-dark' onclick='viewOrder(${val.order_id})'>
                                                <i class='fa fa-eye'></i>
                                            </button>`
                ]).draw().node();
                $(trDOM).addClass('order' + val.order_id + '');
            });

        }
    </script>
@endsection
