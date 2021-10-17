@extends('layouts.admin.master')
@section('page-header')
 {{Auth::user()->is_super_admin == 1 ?  'Business Overview' : 'Dashboard'}}
@endsection
@section('pageCss')
    <style>

    </style>
@endsection
@section('content')

<div class="page-content-wrapper pl-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <h1 class="section-title">Orders</h1>
            </div>
            <div class="col-6 text-right">
                <h1 class="section-title"></h1>
            </div>
        </div>

        <!-- Dashboard Card -->
        <div class="row pt-5">
            <div class="col-12 col-md-6 col-lg-3">
                <a class="todaysOrderUrl" href="{{route('manager.new.order')}}">
                <div class="card m-b-30 card-body dashboardCard orderCard activeOrderCard">
                    <div class="secondCardContent ">
                        <div>
                            <svg width="59" height="59" viewBox="0 0 59 59" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="fluent:clipboard-task-list-ltr-20-filled">
                                    <g id="Group">
                                        <path id="Vector"
                                            d="M25.075 5.90003C24.1596 5.89955 23.2665 6.18301 22.5189 6.71136C21.7713 7.2397 21.206 7.98692 20.9008 8.85002H16.225C15.0515 8.85002 13.9259 9.31623 13.0961 10.1461C12.2663 10.9759 11.8 12.1014 11.8 13.275V48.675C11.8 49.8486 12.2663 50.9741 13.0961 51.804C13.9259 52.6338 15.0515 53.1 16.225 53.1H42.775C43.9486 53.1 45.0742 52.6338 45.904 51.804C46.7338 50.9741 47.2001 49.8486 47.2001 48.675V13.275C47.2001 12.1014 46.7338 10.9759 45.904 10.1461C45.0742 9.31623 43.9486 8.85002 42.775 8.85002H38.0993C37.7941 7.98692 37.2288 7.2397 36.4812 6.71136C35.7336 6.18301 34.8405 5.89955 33.925 5.90003H25.075ZM23.6 10.325C23.6 9.93383 23.7554 9.55866 24.0321 9.28204C24.3087 9.00543 24.6839 8.85002 25.075 8.85002H33.925C34.3162 8.85002 34.6914 9.00543 34.968 9.28204C35.2446 9.55866 35.4 9.93383 35.4 10.325C35.4 10.7162 35.2446 11.0914 34.968 11.368C34.6914 11.6446 34.3162 11.8 33.925 11.8H25.075C24.6839 11.8 24.3087 11.6446 24.0321 11.368C23.7554 11.0914 23.6 10.7162 23.6 10.325ZM27.5943 23.1693L22.4318 28.3318C22.1631 28.6002 21.8012 28.7546 21.4215 28.7629C21.0418 28.7711 20.6735 28.6326 20.3934 28.3761L18.1809 26.3553C18.0306 26.2268 17.9076 26.0694 17.8193 25.8924C17.731 25.7154 17.6793 25.5225 17.6671 25.3251C17.6549 25.1277 17.6825 24.9298 17.7483 24.7433C17.8141 24.5568 17.9167 24.3854 18.0501 24.2394C18.1835 24.0934 18.3449 23.9756 18.5247 23.8932C18.7045 23.8108 18.899 23.7654 19.0967 23.7597C19.2944 23.754 19.4912 23.7881 19.6755 23.86C19.8597 23.9319 20.0276 24.0401 20.1692 24.1782L21.3403 25.2461L25.5057 21.0807C25.6429 20.9436 25.8057 20.8348 25.9849 20.7606C26.1641 20.6864 26.3561 20.6482 26.55 20.6482C26.744 20.6482 26.936 20.6864 27.1152 20.7606C27.2944 20.8348 27.4572 20.9436 27.5943 21.0807C27.7315 21.2179 27.8403 21.3807 27.9145 21.5599C27.9887 21.739 28.0269 21.9311 28.0269 22.125C28.0269 22.319 27.9887 22.511 27.9145 22.6902C27.8403 22.8694 27.7315 23.0322 27.5943 23.1693ZM27.5943 35.8307C27.7317 35.9677 27.8407 36.1305 27.9151 36.3097C27.9894 36.4889 28.0277 36.681 28.0277 36.875C28.0277 37.069 27.9894 37.2611 27.9151 37.4403C27.8407 37.6195 27.7317 37.7823 27.5943 37.9193L22.4318 43.0818C22.1631 43.3502 21.8012 43.5046 21.4215 43.5129C21.0418 43.5211 20.6735 43.3826 20.3934 43.1261L18.1809 41.1053C17.9069 40.838 17.7475 40.4747 17.7365 40.092C17.7254 39.7094 17.8636 39.3374 18.1217 39.0548C18.3799 38.7721 18.7378 38.6009 19.1198 38.5773C19.5019 38.5537 19.8782 38.6795 20.1692 38.9282L21.3403 39.9991L25.5057 35.8307C25.6428 35.6934 25.8055 35.5844 25.9847 35.51C26.1639 35.4357 26.356 35.3974 26.55 35.3974C26.7441 35.3974 26.9362 35.4357 27.1154 35.51C27.2946 35.5844 27.4573 35.6934 27.5943 35.8307ZM32.45 38.35H39.825C40.2162 38.35 40.5914 38.5054 40.868 38.782C41.1446 39.0587 41.3 39.4338 41.3 39.825C41.3 40.2162 41.1446 40.5914 40.868 40.868C40.5914 41.1446 40.2162 41.3 39.825 41.3H32.45C32.0589 41.3 31.6837 41.1446 31.4071 40.868C31.1304 40.5914 30.975 40.2162 30.975 39.825C30.975 39.4338 31.1304 39.0587 31.4071 38.782C31.6837 38.5054 32.0589 38.35 32.45 38.35ZM30.975 25.075C30.975 24.6838 31.1304 24.3087 31.4071 24.032C31.6837 23.7554 32.0589 23.6 32.45 23.6H39.825C40.2162 23.6 40.5914 23.7554 40.868 24.032C41.1446 24.3087 41.3 24.6838 41.3 25.075C41.3 25.4662 41.1446 25.8414 40.868 26.118C40.5914 26.3946 40.2162 26.55 39.825 26.55H32.45C32.0589 26.55 31.6837 26.3946 31.4071 26.118C31.1304 25.8414 30.975 25.4662 30.975 25.075Z"
                                            fill="#08601F"/>
                                    </g>
                                </g>
                            </svg>

                        </div>
                        <div>
                            <h1 class="orderValue new_orders" data-order="{{$total_new_orders}}">{{$total_new_orders}}</h1>
                            <h5>New Orders</h5>
                        </div>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <a class="todaysOrderUrl" href="{{route('manager.order.in.preparation')}}">
                <div class="card m-b-30 card-body dashboardCard">
                    <div class="secondCardContent">
                        <div>
                            <img src="{{asset('backend/assets/icons/emojione-monotone_pot-of-food.svg')}}" alt="">
                        </div>
                        <div>
                            <h1 class="ordersInPreparation">{{$ordersInPreparation}}</h1>
                            <h5>Preparing</h5>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <a class="todaysOrderUrl" href="{{route('manager.order.in.delivery')}}">
                <div class="card m-b-30 card-body dashboardCard">
                    <div class="secondCardContent">
                        <div>
                            <img src="{{asset('backend/assets/icons/ic_round-delivery-dining.svg')}}" alt="">
                        </div>
                        <div>
                            <h1 class="ordersInDelivery">{{$ordersInDelivery}}</h1>
                            <h5>Delivering</h5>
                        </div>
                    </div>
                </div>
                </a>
            </div>

        </div>


    </div><!-- container -->

</div> <!-- Page content Wrapper -->

@endsection
@section('pageScripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="{{asset('backend/assets/js/pusher_notification.js')}}"></script>
    <script>
    let orderValue = $('.orderValue').data('order');
        if (orderValue > 0) {
            $('.orderCard').addClass('activeOrderCard');
        } else {
            $('.orderCard').removeClass('activeOrderCard');

        }
    </script>
@endsection
