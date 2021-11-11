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

                                        <div class="col-lg-4">
                                            <div class="custom-date">
                                                <div class="input-daterange input-group">
                                                    <div class="customDatePicker w-100" style="max-width: none;">
                                                        <img src="{{ asset('backend/assets/icons/dateicon.svg') }}"
                                                            alt="">
                                                        <input type="text" class="form-control" id="datepicker"
                                                            name="fullDate" placeholder="Select Date" />
                                                        <img src="{{ asset('backend/assets/icons/color-arrow-down.svg') }}"
                                                            alt="">
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
                                            <th>Status</th>
                                            <th>Customer Name</th>
                                            <th>Customer Contact</th>
                                            <th>Customer Address</th>
                                            <th>Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr class="table-active">
                                            <td class="col-3 font-weight-bold">TOTAL</td>
                                           
                                            <td class="col-3 font-weight-bold"></td>
                                            <td class="col-3 font-weight-bold"></td>
                                            <td class="col-3 font-weight-bold"></td>
                                            <td class="col-3 font-weight-bold">TOTAL <span class="total_orders">{{$total_order}}</span> ORDERS</td>
                                            <td class="col-3 font-weight-bold"></td>
                                            <td class="col-3 font-weight-bold ">TOTAL <span class="total_amount">{{currency_format($total_orderAmount)}}</span></td>
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
        $(function() {
            $('.performance_li').addClass('sub-nav-active');
            $('.performance_li a').siblings("ul").toggle().removeClass("d-none");
            $('.performance_li a')
                .children("span")
                .children("span")
                .children(".mdi")
                .css("transform", "rotate(0deg)");
            $('.restaurant_li').addClass('nav-active');

            var id = $('#restaurantId').val();
            var url = '{{ route('orders.daily.report', ':id') }}';
            url = url.replace(':id', id);
            var table = $('#orderTable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csvHtml5',
                        filename: 'daily reports',
                        className: 'd-none',
                    },
                    {
                        extend: 'pdfHtml5',
                        filename: 'daily reports',
                        title: 'Daily Reports',
                        className: 'd-none',
                    },
                ],
                serverSide: true,
                ajax: url,
                columns: [

                    {
                        data: 'order_date'
                    },
                    {
                        data: 'id'
                    },
                    {
                        data: 'status'
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
                        data: 'total'
                    },
                ],
            });
            // hideColumn(table);
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
                        $('#orderTable').DataTable().clear().destroy();
                        dataTable();
                        setSessionId(response.data.session_id); // set restaurant id into session
                        setRestaurant(response.data.restaurant_name, response.data
                            .id); // set restaurant into topbar
                        $('.total_orders').html(response.data.total_order);
                        $('.total_amount').html(bdCurrencyFormat(response.data.total_amount));
                        $('.current_date').html(response.data.current_date);




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
                        $('#orderTable').DataTable().clear().destroy();
                        dataTable();
                        setSessionId(response.data.session_id);
                        $('.current_date').html(response.data.current_date);
                        $('.total_orders').html(response.data.total_order);
                        $('.total_amount').html(bdCurrencyFormat(response.data.total_amount));



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

        function dataTable() {
            var id = $('#restaurantId').val();
            var date = $('#datepicker').val();
            var url = '{{ route('date.wise.order.report.restaurant') }}';
            // url = url.replace(':id', id);
            var table = $('#orderTable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csvHtml5',
                        filename: 'daily reports',
                        className: 'd-none',
                    },
                    {
                        extend: 'pdfHtml5',
                        filename: 'daily reports',
                        title: 'Daily Reports',
                        className: 'd-none',
                    },
                ],
                serverSide: true,
                ajax: url,
                columns: [

                    {
                        data: 'order_date'
                    },
                    {
                        data: 'id'
                    },
                    {
                        data: 'status'
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
                        data: 'total'
                    },
                ],
            });
            // hideColumn(table);
        }

        function hideColumn(table) {
            let column2 = table.column(2);
            column2.visible(false);
            let column3 = table.column(3);
            column3.visible(false);
            let column4 = table.column(4);
            column4.visible(false);
            let column5 = table.column(5);
            column5.visible(false);
        }
    </script>
@endsection
