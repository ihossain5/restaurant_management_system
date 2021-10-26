@extends('layouts.frontend.master')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/allOrder.css') }}">
@endsection
@section('title')
    Home
@endsection

@section('content')


    <!-- All Order Table -->
    <section class="large-device-only">
        <div class="row">
            <div class="col-lg-7">
                <div class="allOrder">
                    <h1 class="orderTitle">My orders</h1>
                    @if (session()->has('success'))
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </symbol>
                    </svg>
                    <div class="col-md-12 p-5">
                        <div class="alert alert-success text-center d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                                <use xlink:href="#check-circle-fill" />
                            </svg>
                            <div class="text-center h1">
                                {{ session('success') }} 
                            </div>
                        </div>
                    </div>
                @endif
                    <div class="table-responsive">
                        <table class="table align-middle allOrderTable">
                            <thead>
                                <tr>
                                    <th>ORDER ID</th>
                                    <th>Restaurant</th>
                                    <th>PRICE</th>
                                    <th>DATE</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($orders))
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <button onclick="viewOrder({{$order->order_id}})">#{{$order->getOrderId($order->restaurant->name)}}</button>
                                        </td>
                                        <td>{{$order->restaurant->name}}</td>
                                        <td>Tk. {{currency_format($order->amount)}}</td>
                                        <td>{{formatOrderDate($order->created_at)}}</td>
                                        <td>
                                            <span class="deliveryStatus {{ ( ($order->order_status_id == null) ? 'pendingStatus' : (($order->status->name == 'Completed') ?  'deliverStatus' : 'pendingStatus' ))}}   ">{{$order->status->name ?? 'Pending'}}</span>
                                            <!-- <span class="deliveryStatus deliverStatus">Delivered</span> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <img class="w-100 left-img" src="{{asset('frontend/assets/images/My Orders/image 19.png')}}" alt="">
            </div>
        </div>
    </section>

    <!-- mobile view only -->
    <section class="mobile-view-only">
        <div class="allOrder">
            <h1 class="orderTitle">My orders</h1>
            <div class="order-card-wrapper">
                <div class="order-card-inner">
                    <a data-bs-toggle="modal" href="#orderViewModal" class="d-block text-reset">
                        <div class="row">
                            <div class="col-8 left">
                                <h2 class="title">Kiyoshi</h2>
                                <p class="short-desc">Ebi Meets Sake</p>
                                <span class="status pending">Pending</span>
                            </div>
                            <div class="col-4 right text-end">
                                <h1 class="price">Tk 1,000</h1>
                                <p class="not-visible">empty space</p>
                                <span class="date">18/02/21</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="order-card-inner">
                    <a data-bs-toggle="modal" href="#orderViewModal" class="d-block text-reset">
                        <div class="row">
                            <div class="col-8 left">
                                <h2 class="title">Kiyoshi</h2>
                                <p class="short-desc">Ebi Meets Sake</p>
                                <span class="status completed">Completed</span>
                            </div>
                            <div class="col-4 right text-end">
                                <h1 class="price">Tk 1,000</h1>
                                <p class="not-visible">empty space</p>
                                <span class="date">18/02/21</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="order-card-inner">
                    <a data-bs-toggle="modal" href="#orderViewModal" class="d-block text-reset">
                        <div class="row">
                            <div class="col-8 left">
                                <h2 class="title">Kiyoshi</h2>
                                <p class="short-desc">Ebi Meets Sake</p>
                                <span class="status canceld">Canceled</span>
                            </div>
                            <div class="col-4 right text-end">
                                <h1 class="price">Tk 1,000</h1>
                                <p class="not-visible">empty space</p>
                                <span class="date">18/02/21</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="orderViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="row">
                    <div class="col-12 text-end">
                        <button data-bs-dismiss="modal" class="modalCloseBtn"><img
                                src="{{asset('frontend/assets/images/My Orders/modal-close.svg')}}" alt=""></button>
                    </div>
                </div>

                <div class="orderHistoryBox">

                    <div class="row orderHeader">
                        <div class="col-sm-6 order-1 order-md-0">
                            <h3>Order ID: #<span class="orderId"></span></h3>
                            <p class="date"></p>
                        </div>
                        <div class="col-sm-6  text-sm-end order-0 order-md-1">
                            <div class="pb-5 pb-sm-0">
                                <img id="restaurantImg" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-lg-6 divider">
                            <ul class="orderItem orderItemRow">
                                <!-- Item -->
                            </ul>
                        </div>
                        <div class="col-lg-6 divider2">
                            <ul class="orderPricebox">
                                <li>
                                    <div class="priceName">Sub Total</div>
                                    <div class="orderAmount subtotal">Tk. 1895</div>
                                </li>
                                <li>
                                    <div class="priceName">VAT</div>
                                    <div class="orderAmount">Tk. 85</div>
                                </li>
                                <li>
                                    <div class="priceName">Delivery Fee</div>
                                    <div class="orderAmount">Tk. 60</div>
                                </li>
                                <li>
                                    <div class="priceName">Grand Total</div>
                                    <div class="orderAmount grandTotal">Tk. 2130</div>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <div class="row align-items-center" style="padding-top: 4.5rem;">
                        <div class="col-lg-6 specialNote">
                            <h4>Special Note:</h4>
                            <p class="specialNotes"></p>
                        </div>

                        <div class="col-lg-6 pt-5 pt-lg-0 text-start text-md-end">
                            <button data-bs-dismiss="modal" class="repateOrderBtn">Repeat Order</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('pageScripts')
    <script>
           var config = {
            routes: {
                viewOrder: "{!! route('frontend.customer.order.detail') !!}",
            }
        };
        function viewOrder(id){
            $.ajax({
                url: config.routes.viewOrder,
                method: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    var path = window.location.origin;
                    if (response.success == true) {
                        $('.orderItemRow').empty();
                        $.each(response.data.orderItems, function(i,val){
                            $('.orderItemRow').append(
                                `<li>
                                    <div>
                                        <span class="orderQty">${val.pivot.quantity}x</span>
                                        <span class="orderName">${val.name}</span>
                                    </div>
                                    <div class="orderPrice">Tk ${val.pivot.price}</div>
                                </li>`);
                        });
                        $('.orderId').html(response.data.orderID);
                        $('.date').html(response.data.date);
                        $('.subtotal').html(response.data.amount);
                        $('.grandTotal').html(response.data.grandTotal);
                        $('.specialNotes').html(response.data.special_notes ?? 'N/A');
                        $('#restaurantImg').attr('src', path+'/images/' + response.data.restaurant.logo);
                        $('#orderViewModal').modal('show');

                    } //success end
                },
                error: function(error) {
                    if (error.status == 404) {
                        toastr["error"]('Data not found')
                    }
                },
            }); //ajax end
        }
    </script>
@endsection