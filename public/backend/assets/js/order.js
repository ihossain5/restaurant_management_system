
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

function cancelOrder(id) {
    $.ajax({
        type: "POST",
        url:   main_url+"/manager/cancel-order",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            id: id,
        },    
        dataType: "JSON",
        
        success: function (response) {
            if (response.success === true) {
                $(".cancel_order_badge").html(response.data.cancel_order);
                $(".completed_order_badge").html(response.data.completed_order);
                $("#orderDenyModal").modal("hide");
                toastMixin.fire({
                    icon: "success",
                    animation: true,
                    title: response.data.message,
                });
            }
        },
        error: function (error) {
            if (error.status == 404) {
                toastMixin.fire({
                    icon: "error",
                    animation: true,
                    title: "" + "Data not found" + "",
                });
            }
        },
    });
}

// accept order function
function acceptOrder(id) {
    $.ajax({
        type: "POST",
        url:   main_url+"/manager/accept-order",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            id: id,
        },
        dataType: "JSON",
        success: function (response) {
            if (response.success === true) {
                $(".cancel_order_badge").html(response.data.cancel_order);
                $(".completed_order_badge").html(response.data.completed_order);
                $("#viewModal").modal("hide");
                toastMixin.fire({
                    icon: "success",
                    animation: true,
                    title: response.data.message,
                });
            }
        },
        error: function (error) {
            if (error.status == 404) {
                toastMixin.fire({
                    icon: "error",
                    animation: true,
                    title: "" + "Data not found" + "",
                });
            }
        },
    });
}
