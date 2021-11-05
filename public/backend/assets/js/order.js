var config = {
    routes: {
        view: "{!! route('manager.order.show') !!}",
    }
};

$(document).on('click', '.deny_btn', function() {
    var id = $('#order_id').val();
    $('#cancelBtn').attr('onclick', "cancelOrder(" + id + ")")
        // $('#orderDenyModal').modal('show');
});

$(document).on('click', '.orderCancelRedoBtn', function() {
    $('#viewOrderModal').modal('show');
});


function denyOrder(id) {
    $('#cancelBtn').attr('onclick', "cancelOrder(" + id + ")")
    $('#orderCancelModal').modal('show');
}

// view order function
function viewOrder(id) {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: config.routes.view,
        method: "POST",
        data: {
            id: id,
            // _token: "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function(response) {
            if (response.success == true) {
                setOrderDetails(response);
                orderStatus(response.data.order_status_id, response);
                orderItems(response.data.orderItems);
                addBtnToModal(response.data.order_id);
                $('.view_total').html(bdCurrencyFormat(response.data.amount));
                $('#viewOrderModal').modal('show');

            } //success end

        },
        error: function(error) {
            if (error.status == 404) {
                toastMixin.fire({
                    icon: 'error',
                    animation: true,
                    title: "" + 'Data not found' + ""
                });


            }
        },
    }); //ajax end
}

// // set order item 
function orderItems(orderItems) {
    $('.apeend_tbody').empty();
    $.each(orderItems, function(key, val) {
        var total_price = two_decimal(val.pivot.quantity * val.pivot.price);
        $('.apeend_tbody').append(
            `<tr><td class="item_name">${val.name}</td>
                <td class="item_price">${'TK ' + bdCurrencyFormat( val.price)}</td>
                <td class="item_quantity">${val.pivot.quantity}</td>
                <td class="item_total_price">${'TK ' + bdCurrencyFormat(val.pivot.price) }</td></tr>`
        );
    });
}

// //set order status
function orderStatus(order_status_id, response) {
    if (order_status_id != null) {
        if (response.data.status.name == 'Preparing') {
            var class_name = 'primary';
        } else if (response.data.status.name == 'Delivering') {
            var class_name = 'success';
        } else if (response.data.status.name == 'Completed') {
            var class_name = 'success';
        } else {
            var class_name = 'danger';
        }
        $('#order_status').attr('class', 'btn float-right btn-outline-' + class_name + ' ' +
            response.data.class);
        $('#order_status').text(response.data.status.name);

        if (order_status_id == 4) {
            $('.deny_btn').prop('disabled', true);
            $('.edit_btn').prop('disabled', true);
        } else {
            $('.deny_btn').prop('disabled', false);
            $('.edit_btn').prop('disabled', false);
        }
    }


}

// // set button to modal
function addBtnToModal(order_id) {
    $('.accept_btn').attr('onclick', "acceptOrder(" + order_id + ")")
    $('.orderEditBtn').attr('onclick', "openEditModalAction(" + order_id + ")")
}

// //set order details
function setOrderDetails(response) {
    $('#order_id').val(response.data.order_id);
    $('#view_order_id').text(response.data.id);
    $('#view_customer_name').text(response.data.is_default_name == 1 ? response.data.name :
        response.data.customer.name);
    $('#view_customer_contact').text(response.data.is_default_contact == 1 ? response.data
        .contact : response.data.customer.contact);
    $('#view_customer_address').text(response.data.is_default_address == 1 ? response.data
        .address : response.data.customer.address);
    $('#view_customer_email').text(response.data.customer.email == null ? "N/A" : response.data.customer.email);
    $('#view_notes').text(response.data.special_notes == null ? "N/A" : response.data.special_notes);

    $('.subTotal').html(bdCurrencyFormat(response.data.sutTotal));
    $('.vatAmount').html(bdCurrencyFormat(response.data.vat_amount == null ? 0 : response.data.vat_amount));
    if (response.data.delivery_fee != null) {
        $('.deleveryFee').html(bdCurrencyFormat(response.data.delivery_fee));
    }

}