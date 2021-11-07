@php
use App\Http\Controllers\Manager\ManagerDashboardController;
$status = ManagerDashboardController::restaurant_status();
@endphp
<!-- Top Bar Start -->
       <div class="topbar">
        <nav class="navbar-custom">
            <ul class="list-inline float-right mb-0">
               @if (Auth::user()->is_manager == 1)
               <li class="list-inline-item dropdown notification-list hidden-xs-down">
                <a class="nav-link waves-effect" href="javascript:void(0);" data-toggle="modal"
                    data-target="#restaurentStatusModal">
                    <span class="btnOutlineOpen">{{$status}}</span>
                </a>
            </li>
               @endif

              <!-- restaurant list-->
                @yield('restaurant_list')
            
                <!-- User-->
                <li class="list-inline-item dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                       aria-haspopup="false" aria-expanded="false">
                       @if (Auth::user()->photo != null)
                        <img src="{{asset('images/'.Auth::user()->photo)}}" alt="user" class="rounded-circle">
                        @else 
                        <img src="{{asset('images/default.png')}}" alt="user" class="rounded-circle">
                       @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <a class="dropdown-item" href="{{route(Auth::user()->is_manager == 1 ? 'manager.user.profile' : 'user.profile')}}"><i class="dripicons-user text-muted"></i> Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="dripicons-exit text-muted"></i> Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>

            <!-- Page title -->
            <ul class="list-inline menu-left mb-0">
                <li class="list-inline-item">
                    <button type="button" class="button-menu-mobile open-left waves-effect">
                        <i class="ion-navicon"></i>
                    </button>
                </li>
                <li class="hide-phone list-inline-item app-search">
                    <h3 class="page-title">@yield('page-header')</h3>
                </li>
            </ul>

            <div class="clearfix"></div>
        </nav>

    </div>
    <!-- Top Bar End -->

    
    <div class="modal addModal fade" id="restaurentStatusModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="">
                <h5 class="modal-title text-center" id="exampleModalLabel">Select a Restaurant Status</h5>
                <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-5">
                <div class="row text-center ">
                    <div class="col-12 mb-4">
                        <button class="btnOpen status_btn"data-id="1">Open</button>
                    </div>
                    <div class="col-12 mb-5">
                        <button class="btnClose status_btn"data-id="3">Closed</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>