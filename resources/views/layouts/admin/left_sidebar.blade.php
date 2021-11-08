@php
use App\Http\Controllers\Backend\RestaurantController;
use App\Http\Controllers\Manager\ManagerDashboardController;
$restaurant_id = RestaurantController::getRestaurantIdBySession();
$orders = ManagerDashboardController::countedOrders();
@endphp
<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="">
            <a href="{{ route(Auth::user()->is_manager == 1 ? 'manager.dashboard' : 'dashboard') }}" class="logo">
                {{-- <h6 class="text-center">{{auth()->user()->restaurant->name ?? ''}}</h6> --}}
            </a>
        </div>
        <div class=" card sidebar_user_card m-b-20">
            <div class="card-body">
                <div class="media justify-content-center">
                    @if (Auth::user()->photo == null)
                        <img src="{{ asset('images/default.png') }}" class="left_sidebar_image"
                            alt="user-profle" style="max-width: 100px;height: auto;">
                    @else
                        <img class="d-flex mr-2 rounded-circle thumb-lg"
                            src="{{ asset('images/' . Auth::user()->photo) }}" alt="Generic placeholder image"
                            style="max-width: 100px;height: auto;">
                    @endif
                </div>
                    <h6 class="text-center user_name text-uppercase">{{ Auth::user()->name }}</h6>
                    <div class="text-center">
                        <div class="superAdminDesign">
                            <span> {{(Auth::user()->is_admin ==1) ? 'Admin' : ((Auth::user()->is_super_admin ==1)? 'Super Admin' : 'Manager')}}</span>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="sidebar-inner slimscrollleft">
        <div id="sidebar-menu">
            <ul>

@if (Auth::user()->is_super_admin == 1 || Auth::user()->is_admin ==1)   
        <li>
            <a href="{{ route('dashboard') }}" class="waves-effect"><i class="dripicons-device-desktop "></i><span>
                    Business Overview </span></a>
        </li>
        <li class="has_sub restaurant_li">
            <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-device-desktop"></i><span>My Restaurant
                    <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
            <ul class="list-unstyled">
                <li><a class="restaurant_overview" href="{{ route('restaurant.overview',[$restaurant_id]) }}">Restaurant Overview</a></li>
                {{-- <li><a href="{{ route('location.index') }}">Location Management</a></li>
                <li><a href="{{ route('restaurant.location.index') }}">Restaurant Location </a></li> --}}
                <li><a href="{{ route('restaurant.index') }}">Restaurant Management</a></li>


                <li class="has_multi_sub orders">
                    <a href="javascript:void(0);" class="waves-effect">
                        <span>
                            <i class="fa fa-cutlery"></i> Orders <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                        </span>
                    </a>
                    <ul class="list-unstyledMulti">         
                        <li><a class="order_link" href="{{ route('orders.today',[$restaurant_id]) }}"><i class="fa fa-cutlery"></i>Today's Orders</a></li>
                        <li><a class="past_order_link" href="{{ route('orders.past',[$restaurant_id]) }}"><i class="fa fa-cutlery"></i>Past Orders</a></li>
                    </ul>
                </li>
                <li class="has_multi_sub items_li">
                    <a href="javascript:void(0);" class="waves-effect">
                        <span>
                            <i class="fa fa-cutlery"></i> Item Management <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                        </span>
                    </a>
                    <ul class="list-unstyledMulti">         
                        <li><a class="category_link" href="{{ route('item.category',[$restaurant_id]) }}"><i class="fa fa-cutlery"></i>Item Categories</a></li>   
                        <li><a  class="item_link" href="{{ route('item.index',[$restaurant_id]) }}"><i class="fa fa-cutlery"></i>Items</a></li>
                        <li><a  class="item_combo_link" href="{{ route('item.combo.index',[$restaurant_id]) }}"><i class="fa fa-cutlery"></i>Item Combos</a></li>
                    </ul>
                </li>
                <li class="has_multi_sub performance_li">
                    <a href="javascript:void(0);" class="waves-effect">
                        <span>
                            <i class="fa fa-cutlery"></i> Performance Report <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                        </span>
                    </a>
                    <ul class="list-unstyledMulti">         
                        <li><a class="daily_report_route" href="{{ route('orders.daily.report',[$restaurant_id]) }}"><i class="fa fa-cutlery"></i>Daily Report</a></li>
                <li><a class="time_range_eport_route" href="{{ route('orders.time.range.report',[$restaurant_id]) }}"><i class="fa fa-cutlery"></i>Time Range Report</a></li>
                <li><a class="monthly_report_route" href="{{ route('order.report.restaurant.current.month',[$restaurant_id]) }}"><i class="fa fa-cutlery"></i>Monthly Report</a></li>
                <li><a class="item_performance_report_route" href="{{ route('order.report.item',[$restaurant_id]) }}"><i class="fa fa-cutlery"></i>Item Performance Report</a></li>
                    </ul>
                </li>

            </ul>
        </li>

        <li class="has_sub user_li">
            <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-user"></i><span> Users <span
                        class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
            <ul class="list-unstyled">
                <li><a href="{{ route('admin.admins') }}">Admins</a></li>
                <li class="customer_li"><a href="{{ route('customer.index') }}">Customers</a></li>
                <li><a href="{{ route('restaurant.manager') }}">Restaurant Managers</a></li>
            </ul>
        </li>
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-web"></i><span>Website
                    Content<span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
            <ul class="list-unstyled">
                <li><a href="{{ route('home.hero.section') }}">Home Hero Section</a></li>
                <li><a href="{{ route('about.us') }}">About Us</a></li>
                <li><a href="{{ route('contact.us') }}">Contact Us</a></li>
                {{-- <li><a href="{{ route('asset.type') }}">Asset Type</a></li> --}}
               
            </ul>
        </li>
        
        @endif

 <!-- Manager route start -->
        @if (Auth::user()->is_manager == 1)
        <li>
            <a href="{{ route('manager.dashboard') }}" class="waves-effect"><i class="dripicons-device-desktop "></i><span>
                    Dashboard</span></a>
        </li>
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-device-desktop"></i><span>Orders
                    <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
            <ul class="list-unstyled">
                <li><a  href="{{ route('manager.new.order')}}">New Orders <span class="badge badge-custom new_order_badge">{{$orders['new_order']}}</span></a></li>
                <li><a  href="{{ route('manager.order.in.preparation')}}">Orders In Preparation <span class="badge badge-custom prepation_order_badge">{{$orders['ordersInPreparation']}}</span> </a></li>
                <li><a  href="{{ route('manager.order.in.delivery')}}">Orders In Delivery <span class="badge badge-custom delivery_order_badge">{{$orders['ordersInDelivery']}}</span></a></li>
                <li><a  href="{{ route('manager.completed.order')}}">Completed Orders <span class="badge badge-custom completed_order_badge">{{$orders['completedOrder']}}</span></a></li>
                <li><a  href="{{ route('manager.cancelled.order')}}">Cancelled Orders <span class="badge badge-custom cancel_order_badge">{{$orders['cancelledOrder']}}</span></a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('manager.restaurant.items') }}" class="waves-effect"><i class="fa fa-cutlery"></i><span>
                    Items</span></a>
        </li>
        <li>
            <a href="{{ route('manager.restaurant.item.combos') }}" class="waves-effect"><i class="fa fa-cutlery"></i><span>
                    Item Combos</span></a>
        </li>
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-device-desktop"></i><span>Performance Report
                    <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
            <ul class="list-unstyled">
                <li><a  href="{{ route('manager.daily.sales.report')}}">Daily Sales Report </a></li>
                <li><a  href="{{ route('manager.item.performance.report')}}">Item Performance Report</a></li>
            </ul>
        </li>
        @endif


        </ul>
    </div>
    <div class="clearfix"></div>
</div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->
