<div class="modal alert-modal fade" id="locationAlertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="cartChangeForm" id="alertModalForm"> @csrf
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="alertMessage">If you change location, your cart item will be removed. Are you sure to continue?</h3>
            </div>
            <input type="hidden" name="combo_id" id="modal_combo_id">
            <input type="hidden" name="restaurant_id" id="modal_restaurant_id">
            <input type="hidden" name="item_id" id="modal_item_id">
            <input type="hidden" name="locationId" id="modal_location_id">
            <div class="modal-footer">
                <button type="button" class="alert-modal-btn" data-bs-dismiss="modal">Cancel</button>
                    <a  class="locationModalhref">
                        <button type="button" class="alert-modal-btn fill">Continue</button>
                    </a>
                
            </div>
        </div>
    </form>
    </div>
</div>