
$(document).on('click', '.edit_btn', function() {
    var id = $('#order_id').val();
    $('#viewModal').modal('hide');
    $('#orderEditModal').modal('show');
});
$(document).on('click', '.deny_btn', function() {
    var id = $('#order_id').val();
    $('#editBtn').attr('onclick', "cancelOrder(" + id + ")")
    $('#orderDenyModal').modal('show');
});
$(document).on('click', '.orderCancelRedoBtn', function() {
    $('#viewModal').modal('show');
});

function denyOrder(id){
    $('#editBtn').attr('onclick', "cancelOrder(" + id + ")")
    $('#orderDenyModal').modal('show');
}

var main_url = window.location.origin;



// accept order function

