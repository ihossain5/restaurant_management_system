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
                                        <div class="col-lg-4" id="table-filter">
                                            <select class="form-control custom-select category-select category-drop-down">
                                                <option value="">Select</option>
                                                @if (!empty($restaurant->restaurant_categories))
                                                    @foreach ($restaurant->restaurant_categories as $category)
                                                        <option value="{{ $category->category_id }}">
                                                            {{ $category->name }}
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
                                                        <td>???{{ currency_format($item->pivot->quantity * $item->price) }}
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
                                            <td class="col-3 font-weight-bold"></td>
                                            {{-- <td class="col-3 font-weight-bold">TOTAL 
                                                <span class="total_orders">{{ $total_order }}</span> ORDERS
                                            </td> --}}
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
    <script type='text/javascript'>
        CKEDITOR.replace('restaurant_description');
        var config = {
            routes: {
                getOrdersByRange: "{!! route('order.report.item.date') !!}",
                getItemsBycategory: "{!! route('order.item.report.by.category') !!}",
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
            var url = '{{ route('order.report.item', ':id') }}';
            url = url.replace(':id', id);
            var table = $('#orderTable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csvHtml5',
                        className: 'd-none',
                        filename: 'item report',
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'd-none',
                        filename: 'item report',
                        title: 'Item Report',
                    },
                ],
                serverSide: true,
                ajax: url,

                columns: [{
                        data: 'category.name'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'total_quantity'
                    },
                    {
                        data: 'total_amount'
                    },
                ],
                "drawCallback": function(settings) {
                    // if (settings.json.data == '') {
                    //     $('.total_orders').html(0);
                    //         $('.total_amount').html(`<span class='bdt_symbol'>??? </spam>`+0);
                    // } else {
                    //     $.each(settings.json.data, function(i, val) {
                    //         console.log(val);
                    //         $('.total_orders').html(val.total_order);
                    //         $('.total_amount').html(`<span class='bdt_symbol'>??? </spam>` + val
                    //             .total_amount);
                    //     })
                    // }

                },
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
                            $('.total_amount').html('??? ' + bdCurrencyFormat(response.data
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
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var restaurantId = $('#restaurantId').val();
            var id = $('.category-select').val();
            if (id == '') {
                $('#start_date').val("");
                $('#end_date').val("");
            }
            var url = {
                url: config.routes.getItemsBycategory,
                method: "POST",
                data: {
                    id: id,
                    restaurantId: restaurantId,
                    start_date: start_date,
                    end_date: end_date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
            };
            $('#orderTable').DataTable().clear().destroy();
            dataTable(url);

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
                    "" + '??? ' + bdCurrencyFormat(val.pivot.quantity * val.price) + "",

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
        //                 $('.total_amount').html('??? ' + bdCurrencyFormat(response.data.total_amount));
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

        // category on change function
        $(document).on('change', '.category-select', function() {
            var id = $(this).val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var restaurantId = $('#restaurantId').val();
            if (id == '') {
                $('#start_date').val("");
                $('#end_date').val("");
            }
            var url = {
                url: config.routes.getItemsBycategory,
                method: "POST",
                data: {
                    id: id,
                    restaurantId: restaurantId,
                    start_date: start_date,
                    end_date: end_date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
            };
            $('#orderTable').DataTable().clear().destroy();
            dataTable(url);
        });

        function dataTable(url) {
            var table = $('#orderTable').DataTable({
                // processing: true,
                serverSide: true,
                ajax: url,
                columns: [{
                        data: 'category.name'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'pivot.quantity'
                    },
                    {
                        data: 'revenue',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, full, meta) {
                            return "<span class='bdt_symbol'>???</span>  " + data;
                        }
                    },

                ],
                "drawCallback": function(settings) {
                    if (settings.json.data.length <= 0) {
                        $('.total_orders').html(0);
                        $('.total_amount').html(`<span class='bdt_symbol'>??? </spam>` + 0);
                    }
                    $.each(settings.json.data, function(i, val) {
                        $('.starting_date').html(val.start_date);
                        $('.ending_date').html(val.end_date);
                        $('.total_orders').html(val.total_order);
                        $('.total_amount').html(`<span class='bdt_symbol'>??? </spam>` + val
                        .total_amount);
                    })
                },
            });
        }
    </script>
@endsection
