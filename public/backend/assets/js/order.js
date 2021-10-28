
$(document).on('click', '.deny_btn', function() {
    var id = $('#order_id').val();
    $('#cancelBtn').attr('onclick', "cancelOrder(" + id + ")")
    // $('#orderDenyModal').modal('show');
});

$(document).on('click', '.orderCancelRedoBtn', function() {
    $('#viewOrderModal').modal('show');
});


function denyOrder(id){
    $('#cancelBtn').attr('onclick', "cancelOrder(" + id + ")")
    $('#orderCancelModal').modal('show');
}

// update order function


