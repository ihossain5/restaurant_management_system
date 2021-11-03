<div class="modal alert-modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="cartChangeForm" id="alertModalForm"> @csrf
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="alertMessage"></h3>
            </div>
            <input type="hidden" name="combo_id" id="modal_combo_id">
            <input type="hidden" name="restaurant_id" id="modal_restaurant_id">
            <input type="hidden" name="item_id" id="modal_item_id">
            <div class="modal-footer">
                <button type="button" class="alert-modal-btn" data-bs-dismiss="modal">cancle</button>
                <button type="submit" class="alert-modal-btn fill">continue</button>
            </div>
        </div>
    </form>
    </div>
</div>