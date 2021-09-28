@extends('layouts.admin.master')
@section('page-header')
    Daily Report
@endsection
@section('restaurant_list')
    @include('layouts.admin.restaurant_drop-down')
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
                            <div class="row pb-5">
                                <div class="col-lg-4">
                                    <h4 class="mt-0 header-title">Monthly Report -
                                        <span class="current_month">{{$current_month_name}},</span>
                                        <span class="current_year">{{$year}}</span>
                                    </h4>
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
                                                <div class="input-daterange input-group" id="monthYear">
                                                    <div class="customDatePicker w-100"
                                                        style="max-width: none;">
                                                        <img src="{{asset('backend/assets/icons/dateicon.svg')}}" alt="">
                                                        <input type="text" class="form-control monthYear" name="monthYear"
                                                            placeholder="Select Year Month" />
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
                                                    <td><span>৳</span> {{ currency_format($order->amount) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-active">
                                            <td class="col-3 font-weight-bold">TOTAL</td>
                                            <td class="col-3 font-weight-bold">TOTAL <span class="total_orders">{{$total_order}}</span> ORDERS</td>
                                            <td class="col-3 font-weight-bold ">TOTAL <span class="total_amount">৳ {{currency_format($total_amount)}}</span></td>
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
                getOrdersByMonth: "{!! route('order.report.restaurant.month') !!}",
            }
        };

$(function () {
    var id = $('#restaurantId').val();
    var url = '{{ route("order.report.restaurant.current.month", ":id") }}';
    url = url.replace(':id', id);
    var table = $('#orderTable').DataTable({
        // processing: true,
        serverSide: true,
        ajax: url,
        columns: [
            {data: 'date'},
            {data: 'id'},
            {data: 'amount'},
        ]
     });
  });

        // restaurant change
        $(document).on('click', '.restaurant', function() {
            var id = $(this).data('id');
            var date = $('.monthYear').val();
            $.ajax({
                type: "POST",
                url: config.routes.getOrdersByMonth,
                data: {
                    id: id,
                    date: date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success === true) {
                        $('.restaurant_id').val(response.data.id);
                        $('#orderTable').DataTable().clear().destroy();
                        dataTable();
                        setSessionId(response.data.session_id); // set restaurant id into session
                        setRestaurant(response.data.restaurant_name, response.data.id); // set restaurant into topbar
                        $('.current_year').html(response.data.year);
                        $('.current_month').html(response.data.month + ',');
                        $('.total_orders').html(response.data.total_order);
                        $('.total_amount').html('৳ ' + bdCurrencyFormat(response.data.total_amount));
                        // if($.trim(response.data.orders) ){
                        //     ordersData(response.data.orders)
                        // }
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
        $(".monthYear").on("change", function() {
            var date = $(this).val();
            var restaurant_id = $('#restaurantId').val();
            $.ajax({
                type: "POST",
                url: config.routes.getOrdersByMonth,
                data: {
                    id: restaurant_id,
                    date: date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success === true) {
                        $('.restaurant_id').val(response.data.id);
                        $('#orderTable').DataTable().clear().destroy();
                        setSessionId(response.data.session_id);
                        dataTable();
                        $('.current_year').html(response.data.year);
                        $('.current_month').html(response.data.month + ',');
                        $('.total_orders').html(response.data.total_order);
                        $('.total_amount').html('৳ ' + bdCurrencyFormat(response.data.total_amount));
                        // if($.trim(response.data.orders) ){
                        //     ordersData(response.data.orders)
                        // }


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
    function dataTable(){
    var url = '{{ route("date.wise.order.report.restaurant") }}';
    // url = url.replace(':id', id);
    var table = $('#orderTable').DataTable({
        // processing: true,
        serverSide: true,
        ajax: url,
        columns: [
            {data: 'date'},
            {data: 'id'},
            {data: 'amount'},
        ]
    });
    } 
    </script>
@endsection
