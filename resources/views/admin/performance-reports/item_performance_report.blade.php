@extends('layouts.admin.master')
@section('page-header')
    Item Performance Report
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
                                    <h4 class="mt-0 header-title">Item Performance Report - {{ $monthName }}
                                        {{-- <span class="starting_date"></span> -
                                        <span class="ending_date"></span> --}}
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
                                            <select class="form-control custom-select category-select category-drop-down">
                                                <option value="">Item Category</option>
                                                @if (!empty($categories))
                                                    @foreach ($categories as $category)
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
                                        @if (!empty($newItems))
                                            @foreach ($newItems as $item)
                                                <tr class="item{{ $item->item_id }}">
                                                    <td>{{ $item->category->name }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->pivot->quantity }}</td>
                                                    <td>{{ currency_format($item->pivot->price) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-active">
                                            <td class="col-3 font-weight-bold"></td>
                                            <td class="col-3 font-weight-bold"></td>
                                            <td class="col-3 font-weight-bold"></td>
                                            {{-- <td class="col-3 font-weight-bold">TOTAL <span class="total_orders"></span> ORDERS</td> --}}
                                            <td class="col-3 font-weight-bold ">TOTAL <span
                                                    class="total_amount">{{ currency_format($total) }}</span></td>
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
                getOrderItems: "{!! route('order.items.report') !!}",
            }
        };

        $('.performance_li').addClass('sub-nav-active');
            $('.performance_li a').siblings("ul").toggle().removeClass("d-none");
            $('.performance_li a')
                .children("span")
                .children("span")
                .children(".mdi")
                .css("transform", "rotate(0deg)");
            $('.restaurant_li').addClass('nav-active');

        // restaurant change
        $(document).on('click', '.restaurant', function() {
            var end_date = $('#end_date').val();
            var restaurant_id = $('#restaurantId').val();
            var start_date = $('#start_date').val();
            var category_id = $('.category-select').val();
            var id = $(this).data('id');

            $.ajax({
                type: "POST",
                url: config.routes.getOrderItems,
                data: {
                    restaurant_id: id,
                    category_id: category_id,
                    start_date: start_date,
                    end_date: end_date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success === true) {
                        $('.restaurant_id').val(response.data.restaurant_id);
                        setSessionId(response.data.session_id); // set restaurant id into session
                        setRestaurant(response.data.restaurant_name, response.data
                            .restaurant_id); // set restaurant into topbar

                        $('#orderTable').DataTable().clear().draw();
               
                        $('.total_amount').html(bdCurrencyFormat(response.data.total));
                        $('.header-title').empty();
                        if (response.data.start_date) {
                            $('.header-title').append(
                                ` <h4 class="mt-0 header-title">Item Performance Report - 
                                        <span class="starting_date">${response.data.start_date}</span> -
                                        <span class="ending_date">${response.data.end_date}</span> 
                                    </h4>`
                            )
                        } else if (response.data.monthName) {
                            $('.header-title').append(
                                ` <h4 class="mt-0 header-title">
                                    Item Performance Report - ${response.data.monthName}
                                    </h4>`
                            )
                        }
                        if ($.trim(response.data.items)) {
                            var orderTable = $('#orderTable').DataTable();
                            $.each(response.data.items, function(key, val) {
                                var trDOM = orderTable.row.add([
                                    "" + val.category.name + "",
                                    "" + val.name + "",
                                    "" + val.pivot.quantity + "",
                                    "" + val.pivot.price + "",
                                ]).draw().node();
                                $(trDOM).addClass('item' + val.item_id + '');
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

        });




        // category on change function
        $(document).on('change', '.category-select', function() {
            var id = $(this).val();
            var end_date = $('#end_date').val();
            var restaurant_id = $('#restaurantId').val();
            var start_date = $('#start_date').val();

            $.ajax({
                url: config.routes.getOrderItems,
                method: "POST",
                data: {
                    restaurant_id: restaurant_id,
                    category_id: id,
                    start_date: start_date,
                    end_date: end_date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        setSessionId(response.data.session_id);
                        $('.restaurant_id').val(response.data.restaurant_id);

                        $('#orderTable').DataTable().clear().draw();
                        $('.total_amount').html(bdCurrencyFormat(response.data.total));
                        $('.header-title').empty();
                        if (response.data.start_date) {
                            $('.header-title').append(
                                ` <h4 class="mt-0 header-title">Item Performance Report - 
                                        <span class="starting_date">${response.data.start_date}</span> -
                                        <span class="ending_date">${response.data.end_date}</span> 
                                    </h4>`
                            )
                        } else if (response.data.monthName) {
                            $('.header-title').append(
                                ` <h4 class="mt-0 header-title">
                                    Item Performance Report - ${response.data.monthName}
                                    </h4>`
                            )
                        }
                        if ($.trim(response.data.items)) {
                            var orderTable = $('#orderTable').DataTable();
                            $.each(response.data.items, function(key, val) {
                                var trDOM = orderTable.row.add([
                                    "" + val.category.name + "",
                                    "" + val.name + "",
                                    "" + val.pivot.quantity + "",
                                    "" + val.pivot.price + "",
                                ]).draw().node();
                                $(trDOM).addClass('item' + val.item_id + '');
                            });
                        }

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


        });

        // get orders by date
        $(".customDatePicker").on("change", function() {
            var end_date = $('#end_date').val();
            var restaurant_id = $('#restaurantId').val();
            var start_date = $('#start_date').val();

            var id = $('.category-select').val();

            console.log(start_date, end_date);

            $.ajax({
                url: config.routes.getOrderItems,
                method: "POST",
                data: {
                    restaurant_id: restaurant_id,
                    category_id: id,
                    start_date: start_date,
                    end_date: end_date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        setSessionId(response.data.session_id);
                        $('.restaurant_id').val(response.data.restaurant_id);

                        $('#orderTable').DataTable().clear().draw();
                        $('.total_amount').html(bdCurrencyFormat(response.data.total));
                        $('.header-title').empty();
                        if (response.data.start_date) {
                            $('.header-title').append(
                                ` <h4 class="mt-0 header-title">Item Performance Report - 
                                        <span class="starting_date">${response.data.start_date}</span> -
                                        <span class="ending_date">${response.data.end_date}</span> 
                                    </h4>`
                            )
                        } else if (response.data.monthName) {
                            $('.header-title').append(
                                ` <h4 class="mt-0 header-title">
                                    Item Performance Report - ${response.data.monthName}
                                    </h4>`
                            )
                        }
                        if ($.trim(response.data.items)) {
                            var orderTable = $('#orderTable').DataTable();
                            $.each(response.data.items, function(key, val) {
                                var trDOM = orderTable.row.add([
                                    "" + val.category.name + "",
                                    "" + val.name + "",
                                    "" + val.pivot.quantity + "",
                                    "" + val.pivot.price + "",
                                ]).draw().node();
                                $(trDOM).addClass('item' + val.item_id + '');
                            });
                        }

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

        });
        // 
    </script>
@endsection
