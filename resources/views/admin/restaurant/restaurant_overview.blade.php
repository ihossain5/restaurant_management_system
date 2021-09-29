@extends('layouts.admin.master')
@section('page-header')
    Restaurant Overview (Daily)
@endsection
@section('restaurant_list')
    @include('layouts.admin.restaurant_drop-down')
@endsection
@section('pageCss')
    <style>
        .card_icon i {
            font-size: 60px;
            color: #294373;
            vertical-align: middle;
            align-content: center;
        }

        .icon_color {
            color: #294373;
        }

        .set_height {
            min-height: 160px;
        }

        .card_icon {
            margin-left: 50px;
            padding-top: 30px;
        }
        .card p{
            font-size: 14px;
            font-weight: 600;
            color: black;
        }
        .report_card{
            height: 130px;
        }

    </style>
@endsection
@section('content')
    <div class="preloader"></div>

    <div class="page-content-wrapper">
        <div class="container-fluid">
            <h5>Orders</h5>
            <hr>

            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card text-center report_card">
                        {{-- <a href="{{route('quotation.unapproved')}}"> --}}
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4 ">
                                <div class="mb-2 card-body card_icon">
                                    <i class="fa fa-clipboard"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-2 card-body text-muted">
                                    <h3 class="icon_color new_orders">{{ $new_orders }}</h3>
                                    <p> New Orders</p>
                                </div>
                            </div>
                        </div>
                        {{-- </a> --}}
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card text-center report_card">
                        {{-- <a href="{{route('quotation.redo')}}"> --}}
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4 ">
                                <div class="mb-2 card-body card_icon">
                                    <i class="fa fa-clipboard"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-2 card-body text-muted">
                                    <h3 class=" icon_color ordersInPreparation">{{ $ordersInPreparation }}</h3>
                                    <p>Orders in Preparation</p>
                                </div>
                            </div>
                        </div>
                        {{-- </a> --}}
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card text-center report_card">
                        {{-- <a href="{{route('quotation.redo')}}"> --}}
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4 ">
                                <div class="mb-2 card-body card_icon">
                                    <i class="fa fa-clipboard"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-2 card-body text-muted">
                                    <h3 class=" icon_color ordersInDelivery">{{ $ordersInDelivery }}</h3>
                                    <p>Orders in Delivery</p>
                                </div>
                            </div>
                        </div>
                        {{-- </a> --}}
                    </div>

                </div>
            </div>
            <h5>Performance</h5>
            <hr>

            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card text-center report_card">
                        {{-- <a href="{{route('quotation.unapproved')}}"> --}}
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4 ">
                                <div class="mb-2 card-body card_icon">
                                    <i class="fa fa-clipboard"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-2 card-body text-muted">
                                    <h3 class=" icon_color completedOrders">{{ $completedOrders }}</h3>
                                    <p>Total Completed Orders</p>
                                </div>
                            </div>
                        </div>
                        {{-- </a> --}}
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card text-center report_card">
                        {{-- <a href="{{route('quotation.redo')}}"> --}}
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4 ">
                                <div class="mb-2 card-body card_icon">
                                    <i class="fa fa-clipboard"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-2 card-body text-muted">
                                    <h3 class=" icon_color cancelledOrders">{{ $cancelledOrders }}</h3>
                                    <p>Total Cancelled Orders</p>
                                </div>
                            </div>
                        </div>
                        {{-- </a> --}}
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card text-center report_card">
                        {{-- <a href="{{route('quotation.redo')}}"> --}}
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-4 ">
                                <div class="mb-2 card-body card_icon">
                                    <i class="fa fa-cutlery"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-2 card-body text-muted">
                                    <h3 class=" icon_color total_revenue">BDT {{ currency_format($total_revenue) }}</h3>
                                    <p>Revenue</p>
                                </div>
                            </div>
                        </div>
                        {{-- </a> --}}
                    </div>

                </div>
            </div>

        </div><!-- container -->

    </div> <!-- Page content Wrapper -->

@endsection
@section('pageScripts')
    <script>
        var config = {
            routes: {
                getReport: "{!! route('order.report.restaurant') !!}",
            }
        };
           // restaurant change
           $(document).on('click', '.restaurant', function() {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: config.routes.getReport,
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success === true) {
                        $('.restaurant_id').val(response.data.id);

                        setSessionId(response.data.session_id); // set restaurant id into session
                        setRestaurant(response.data.restaurant_name, response.data.id); // set restaurant into topbar
                        $('.new_orders').html(response.data.new_orders);
                        $('.ordersInDelivery').html(response.data.ordersInDelivery);
                        $('.ordersInDelivery').html(response.data.ordersInDelivery);
                        $('.ordersInPreparation').html(response.data.ordersInPreparation);
                        $('.cancelledOrders').html(response.data.cancelledOrders);
                        $('.completedOrders').html(response.data.completedOrders);
                        $('.total_revenue').html(bdCurrencyFormat(response.data.total_revenue));

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
    </script>
@endsection