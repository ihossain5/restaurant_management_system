@extends('layouts.admin.master')
@section('page-header')
    Item Performance Report
@endsection


@section('pageCss')
    <style>
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
                            <div class="row pb-5">
                                <div class="col-lg-4">
                                    <h4 class="mt-0 header-title">Item Performance Report - {{ $monthName }}
                                        {{-- <span class="starting_date"></span> -
                                        <span class="ending_date"></span> --}}
                                    </h4>
                                </div>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-3 p-0">
                                            <select class="form-control custom-select category-select">
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
                                                        <input type="text" class="form-control start_date date" name="start"
                                                            placeholder="Start Date" />
                                                        <img src="{{ asset('backend/assets/icons/color-arrow-down.svg') }}"
                                                            alt="">
                                                    </div>

                                                    <div class="customDatePicker">
                                                        <img src="{{ asset('backend/assets/icons/dateicon.svg') }}"
                                                            alt="">
                                                        <input type="text" class="form-control end_date date" name="end"
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

                            <span class="showError"></span>
                            <div class="table-responsive">
                                <table id="orderTable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Items</th>
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
                                                    <td>{{ currency_format($item->pivot->price)  }}</td>
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


    <input type="hidden" name="" id="managerRestaurantId" value="{{ Auth::user()->restaurant->restaurant_id }}">
@endsection
@section('pageScripts')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="{{ asset('backend/assets/js/pusher_notification.js') }}"></script>
    <script type='text/javascript'>
        var config = {
            routes: {
                getItems: "{!! route('manager.item.performance.by.date') !!}",
            }
        };



        // category on change function
        $(document).on('change', '.category-select', function() {
            var id = $(this).val();
            var start_date = $('.start_date').val();
            var end_date = $('.end_date').val();

            $.ajax({
                url: config.routes.getItems,
                method: "POST",
                data: {
                    category_id: id,
                    start_date: start_date,
                    end_date: end_date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
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
        $(".date").on("change", function() {
            var start_date = $('.start_date').val();
            var end_date = $('.end_date').val();
            var id = $('.category-select').val();

            $.ajax({
                url: config.routes.getItems,
                method: "POST",
                data: {
                    category_id: id,
                    start_date: start_date,
                    end_date: end_date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
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
