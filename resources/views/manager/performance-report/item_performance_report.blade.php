@extends('layouts.admin.master')
@section('page-header')
    Item Performance Report
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
                            <div class="row pb-5">
                                <div class="col-lg-4">
                                    <h4 class="mt-0 header-title">Item Performance Report - 
                                        <span class="starting_date"></span> -
                                        <span class="ending_date"></span> 
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
                                                        <img src="{{ asset('backend/assets/icons/dateicon.svg') }}" alt="">
                                                        <input type="text" class="form-control start_date date" name="start"
                                                            placeholder="Start Date" />
                                                        <img src="{{ asset('backend/assets/icons/color-arrow-down.svg') }}"
                                                            alt="">
                                                    </div>

                                                    <div class="customDatePicker">
                                                        <img src="{{ asset('backend/assets/icons/dateicon.svg') }}" alt="">
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
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-active">
                                            <td class="col-3 font-weight-bold">TOTAL</td>
                                            <td class="col-3 font-weight-bold"></td>
                                            <td class="col-3 font-weight-bold">TOTAL <span class="total_orders"></span> ORDERS</td>
                                            <td class="col-3 font-weight-bold ">TOTAL <span class="total_amount"></span></td>
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
                getItems: "{!! route('manager.item.performance.by.date') !!}",
            }
        };

        $(function() {
            var url = '{{ route('manager.item.performance.report') }}';
            dataTable(url);
        });

    // category on change function
    $(document).on('change', '.category-select', function() {
            var id = $(this).val();
            var start_date = $('.start_date').val();
            var end_date = $('.end_date').val();
            if(id == ''){
                $('.start_date').val("");
                $('.end_date').val("");
            }
            var url = {
                url: config.routes.getItems,
                method: "POST",
                data: {
                    id: id,
                    start_date: start_date,
                    end_date: end_date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",};
            $('#orderTable').DataTable().clear().destroy();
            dataTable(url);
        });

        // get orders by date
        $(".date").on("change", function() {
            var start_date = $('.start_date').val();
            var end_date = $('.end_date').val();
            var id = $('.category-select').val();
       
            var url = {
                url: config.routes.getItems,
                method: "POST",
                data: {
                    id: id,
                    start_date: start_date,
                    end_date: end_date,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",};
            $('#orderTable').DataTable().clear().destroy();
            dataTable(url);
        });
        // 

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
                            return "<span class='bdt_symbol'>৳</span>  " + data;
                        }
                    },

                ],
                "drawCallback": function(settings) {
                    $.each(settings.json.data, function(i,val){
                      $('.starting_date').html(val.start_date);
                      $('.ending_date').html(val.end_date);
                      $('.total_orders').html(val.total_order);
                      $('.total_amount').html(`<span class='bdt_symbol'>৳ </spam>`+ val.total_amount);
                    })
                },
            });
        }
    </script>
@endsection
