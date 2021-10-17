@php
use App\Http\Controllers\Manager\ManagerDashboardController;
$orders = ManagerDashboardController::countedOrders();
@endphp
  <!-- order deny  Modal -->
    <div class="modal fade bs-example-modal-center" id="notificationModal" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header d-block">
                    <h5 class="modal-title mt-0 text-center">Are you sue you want to cancel?</h5>
                    <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="message"></div>
                    <div class="numberOfNewOrder"></div>
                    <input type="hidden" class="order_number" value="{{$orders['new_order'] ?? ''}}">
                </div>
                <div class="modal-footer deny-modal-footer">
                    <button id="editBtn" type="button" class="btn btn-block btn-danger waves-effect waves-light">
                        click, Item
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- order deny Modal End -->