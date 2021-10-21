@php
use App\Http\Controllers\Manager\ManagerDashboardController;
$orders = ManagerDashboardController::countedOrders();
@endphp
 <div class="modal fade" id="allNewOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered orderNotifModal">
            <div class="modal-content modal-body">
                <div class="ringIcon">
                    <img src="{{asset('backend/assets/icons/bx_bxs-bell-ring.svg')}}" alt="">
                </div>
                <div class="ringContent">
                    <h6>You have</h6>
                    <div>
                        <h2 id="newOrders"></h2>
                    </div>
                    <h6>New Order !</h6>
                    <a href="{{route('manager.new.order')}}">
                        <button>check them</button>
                    </a>
                </div>
            </div>
        </div>
    </div>