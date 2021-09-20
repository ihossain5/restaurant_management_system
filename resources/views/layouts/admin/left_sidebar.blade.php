<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="">
            <!--<a href=" index.html" class="logo text-center">Fonik</a>-->
            <a href="{{ route('dashboard') }}" class="logo">
                <h6 class="text-center">App Logo</h6>
                {{-- <img src="{{asset('backend/assets/images/logo.png')}}" height="20" alt="logo"> --}}
            </a>
        </div>


    </div>

    <div class="sidebar-inner slimscrollleft">
        <div id="sidebar-menu">
            <ul>
                <div class="">
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
                        <div>
                            <h6 class="text-center user_name text-uppercase">{{ Auth::user()->name }}</h6>
                            <div class="d-flex justify-content-center pt-2" style="font-size: 16px;">

                                @if (Auth::user()->is_super_admin == 1)
                                    <span class="badge badge-primary  p-1">Super Admin</span>
                                @elseif(Auth::user()->is_manager==1)
                                    <span class="badge badge-primary  p-1">Manager</span>
                                @else

                                    <span class="badge badge-primary  p-1">User</span>
                                @endif
                            </div>
                        </div>


                    </div>
                </div>

        </div>

@if (Auth::user()->is_super_admin == 1)   
        {{-- <li class="menu-title">Main</li> --}}

        <li>
            <a href="{{ route('dashboard') }}" class="waves-effect"><i class="dripicons-device-desktop "></i><span>
                    Business Overview </span></a>
        </li>

        {{-- <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-user"></i><span>My Restaurants
                    <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
            <ul class="list-unstyled">
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-cutlery" aria-hidden="true"></i><span>Items
                            Management<span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home.hero.section') }}">Home Hero Section</a></li>
                    </ul>
                </li>
            </ul>
        </li> --}}

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-user"></i><span> Users <span
                        class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
            <ul class="list-unstyled">
                {{-- <li><a href="{{ route('admin.admins') }}">Admins</a></li> --}}
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
                <li><a href="{{ route('restaurant.index') }}">Restaurants</a></li>
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-device-desktop"></i><span>My Restaurant
                    <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
            <ul class="list-unstyled">
                <li><a class="restaurant_overview" href="{{ route('restaurant.overview',[session()->get('restaurant_id') ?? 1]) }}">Restaurant Overview</a></li>
            </ul>
        </li>


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-cutlery"></i><span>Item
                Management<span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
            <ul class="list-unstyled">
                {{-- <li><a href="{{ route('item.category.index') }}"><i class="fa fa-cutlery"></i>Item Categories</a></li> --}}
                <li><a class="category_link" href="{{ route('item.category',[session()->get('restaurant_id') ?? 1]) }}"><i class="fa fa-cutlery"></i>Item Categories</a></li>
                {{-- <li><a class="category_link" href="{{ route('item.category',[1]) }}"><i class="fa fa-cutlery"></i>Item Categories</a></li> --}}
                {{-- <li><a href="{{ route('item.index') }}"><i class="fa fa-cutlery"></i>Items</a></li> --}}
                <li><a  class="item_link" href="{{ route('item.index',[session()->get('restaurant_id') ?? 1]) }}"><i class="fa fa-cutlery"></i>Items</a></li>
                {{-- <li><a  class="item_link" href="{{ route('item.index',[9]) }}"><i class="fa fa-cutlery"></i>Items</a></li> --}}
            </ul>
        </li>

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-cutlery"></i><span>Orders<span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
            <ul class="list-unstyled">
                <li><a class="order_link" href="{{ route('orders.today',[session()->get('restaurant_id') ?? 1]) }}"><i class="fa fa-cutlery"></i>Today's Orders</a></li>
                <li><a class="past_order_link" href="{{ route('orders.past',[session()->get('restaurant_id') ?? 1]) }}"><i class="fa fa-cutlery"></i>Past Orders</a></li>
            </ul>
        </li>
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-cutlery"></i><span>Performance Report<span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
            <ul class="list-unstyled">
                <li><a class="daily_report_route" href="{{ route('orders.daily.report',[session()->get('restaurant_id')]) }}"><i class="fa fa-cutlery"></i>Daily Report</a></li>
                <li><a class="time_range_eport_route" href="{{ route('orders.time.range.report',[session()->get('restaurant_id')?? 1]) }}"><i class="fa fa-cutlery"></i>Time Range Report</a></li>
                <li><a class="monthly_report_route" href="{{ route('orders.past',[session()->get('restaurant_id')?? 1]) }}"><i class="fa fa-cutlery"></i>Monthly Report</a></li>
                <li><a class="item_performance_report_route" href="{{ route('orders.past',[session()->get('restaurant_id')?? 1]) }}"><i class="fa fa-cutlery"></i>Item Performance Report</a></li>
            </ul>
        </li>
        
        @endif

 <!-- Manager route start -->
        @if (Auth::user()->is_manager == 1)
        <li>
            <a href="{{ route('dashboard') }}" class="waves-effect"><i class="dripicons-device-desktop "></i><span>
                    Dashboard</span></a>
        </li>
         <li>
            <a href="{{ route('restaurant.items') }}" class="waves-effect"><i class="fa fa-cutlery"></i><span>
                    Item</span></a>
        </li>
        @endif


        </ul>
    </div>
    <div class="clearfix"></div>
</div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->
