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
                                    <h4 class="mt-0 header-title">Item Performance Report
                                        <span class="start_date"></span>
                                        <span class="end_date"></span>
                                    </h4>
                                </div>
                                <div class="col-lg-8">
                                    <div class="row">
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
                                                    <button><img src="{{ asset('backend/assets/icons/pdf-icon.svg') }}"
                                                            alt=""> PDF
                                                        File</button>
                                                    <button><img src="{{ asset('backend/assets/icons/csv-icon.svg') }}"
                                                            alt=""> CSV
                                                        File</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" id="table-filter">
                                            <select class="form-control custom-select category-drop-down">
                                                <option>Select</option>
                                                @if (!empty($restaurant->restaurant_categories))
                                                    @foreach ($restaurant->restaurant_categories as $category)
                                                        <option value="{{ $category->name }}">{{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="custom-date">
                                                <div class="input-daterange input-group" id="date-range">
                                                    <div class="customDatePicker">
                                                        <img src="{{ asset('backend/assets/icons/dateicon.svg') }}"
                                                            alt="">
                                                        <input type="text" class="form-control" name="start"
                                                            id="start_date" placeholder="Start Date" />
                                                        <img src="{{ asset('backend/assets/icons/color-arrow-down.svg') }}"
                                                            alt="">
                                                    </div>

                                                    <div class="customDatePicker">
                                                        <img src="{{ asset('backend/assets/icons/dateicon.svg') }}"
                                                            alt="">
                                                        <input type="text" class="form-control" name="end" id="end_date"
                                                            placeholder="End Date" />
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
                                        <tr></tr>
                                        <tr>
                                            <th>Category</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @if (!empty($restaurant->restaurant_orders))
                                            @foreach ($restaurant->restaurant_orders as $order)
                                                @foreach ($order->items as $item)
                                                    <tr class="order{{ $order->order_id }}">
                                                        <td> {{ $item->category->name }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->pivot->quantity }}</td>
                                                        <td>৳{{ currency_format($item->pivot->quantity * $item->price) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endif --}}
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-active">
                                            <td class="col-3 font-weight-bold">TOTAL</td>
                                            <td class="col-3 font-weight-bold"></td>
                                            <td class="col-3 font-weight-bold">TOTAL <span
                                                    class="total_orders">{{ $total_order }}</span> ORDERS</td>
                                            <td class="col-3 font-weight-bold ">TOTAL <span
                                                    class="total_amount">{{ $total_amount }}</span></td>
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
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script type='text/javascript'>
     CKEDITOR.replace('restaurant_description');
        var config = {
            routes: {
                getOrdersByRange: "{!! route('order.report.item.date') !!}",
            }
        };

$(function () {
    $('.performance_li').addClass('sub-nav-active');
            $('.performance_li a').siblings("ul").toggle().removeClass("d-none");
            $('.performance_li a')
                .children("span")
                .children("span")
                .children(".mdi")
                .css("transform", "rotate(0deg)");
            $('.restaurant_li').addClass('nav-active');
    var id = $('#restaurantId').val();
    var url = '{{ route("order.report.item", ":id") }}';
    url = url.replace(':id', id);
    var table = $('#orderTable').DataTable({
        // processing: true,
        serverSide: true,
        ajax: url,
      
        columns: [
            {data: 'category.name'},
            {data: 'name'},
            {data: 'pivot.quantity'},
            {data: 'revenue'},
        ]
     });
  });


        // restaurant change
        $(document).on('click', '.restaurant', function() {
            var id = $(this).data('id');
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date == '' && end_date == '') {
                toastMixin.fire({
                    icon: 'error',
                    animation: true,
                    title: "" + 'Please slelect start date & end date' + ""
                });
            } else {
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
                            setSessionId(response.data.session_id); // set restaurant id into session
                            setRestaurant(response.data.restaurant_name, response.data
                            .id); // set restaurant into topbar
                            $('.start_date').html('- ' + response.data.start_date + ' -');
                            $('.end_date').html(response.data.end_date);
                            $('.total_orders').html(response.data.total_order);
                            $('.total_amount').html('৳ ' + bdCurrencyFormat(response.data
                            .total_amount));
                            $('.current_date').html(response.data.current_date);
                            if ($.trim(response.data.orders)) {
                                $.each(response.data.orders, function(key, order) {
                                    ordersData(order.items)
                                });
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


        // get orders by date
        $(".customDatePicker").on("change", function() {
            var end_date = $('#end_date').val();
            var restaurant_id = $('#restaurantId').val();
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
                            $('.start_date').html('- ' + response.data.start_date + ' -');
                            $('.end_date').html(response.data.end_date);
                            $('.total_orders').html(response.data.total_order);
                            $('.total_amount').html('৳ ' + bdCurrencyFormat(response.data
                            .total_amount));
                            if ($.trim(response.data.orders)) {
                                $.each(response.data.orders, function(key, order) {
                                    ordersData(order.items)
                                });

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
            $.each(orders, function(i, val) {
                // console.log(val.pivot.quantiy);
                var trDOM = orderTable.row.add([
                    "" + val.category.name + "",
                    "" + val.name + "",
                    "" + val.pivot.quantity + "",
                    "" + '৳ ' + bdCurrencyFormat(val.pivot.quantity * val.price) + "",

                ]).draw().node();
                $(trDOM).addClass('order' + val.order_id + '');
            });

        }

        // $(document).on('change', '.category-drop-down', function() {
        //     var category_id = $(this).val();
        //     var end_date = $('#end_date').val();
        //     var start_date = $('#start_date').val();
        //     $.ajax({
        //         type: "POST",
        //         url: config.routes.getItemReportByDate,
        //         data: {
        //             category_id: category_id,
        //             start_date: start_date,
        //             end_date: end_date,
        //             _token: "{{ csrf_token() }}"
        //         },
        //         dataType: 'JSON',
        //         success: function(response) {
        //             if (response.success === true) {
        //                 $('.restaurant_id').val(response.data.id);
        //                 $('#orderTable').DataTable().clear().draw();
        //                 setSessionId(response.data.session_id);
        //                 $('.current_date').html(response.data.current_date);
        //                 $('.total_orders').html(response.data.total_order);
        //                 $('.total_amount').html('৳ ' + bdCurrencyFormat(response.data.total_amount));
        //                 if ($.trim(response.data.orders)) {
        //                     ordersData(response.data.orders)
        //                 }


        //             }
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
        //     });
        // });
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
