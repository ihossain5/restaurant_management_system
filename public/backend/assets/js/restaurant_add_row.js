

var config = {
    routes: {
        addRestaurant: "{!! route('restaurant.store') !!}",
    }
};
$(document).ready(function() {
    // add form validation
    $("#restaurantAddForm").validate({
        ignore: [],
        rules: {
            name: {
                required: true,
                maxlength: 100,
            },
            'asset[][asset_type_id]': {
                    required: true
                    },
            'asset[][asset]': {
                    required: true
                    },
            type: {
                required: true,
                maxlength: 100,
            },
            contact: {
                required: true,
                maxlength: 100,
            },
            email: {
                required: true,
                email: true,
                maxlength: 100,
            },
            description: {
                required: true,
                maxlength: 10000,
            },
            address: {
                required: true,
                maxlength: 10000,
            },
            logo: {
                required: true,
            },
        },
        messages: {
            name: {
                required: 'Please insert restaurant name',
            },
            type: {
                required: 'Please insert restaurant type',
            },
            contact: {
                required: 'Please insert restaurant contact number',
            },
            email: {
                required: 'Please insert restaurant email',
                email: 'Email must be valid',
            },
            description: {
                required: 'Please insert restaurant description',
            },
            address: {
                required: 'Please insert restaurant address',
            },
            logo: {
                required: 'Please upload restaurant logo',
            },
        },
        errorPlacement: function(label, element) {
            label.addClass('mt-2 text-danger');
            label.insertAfter(element);
        },
    });

});

var i = 0;
function addRow() {
    var asset = $(".asset_row")
        .find("#asset" + i)
        .val();
    if (asset === "") {
        $(".error_msg" + i)
            .addClass("mt-1")
            .text("Please upload photo");
        $(".error_msg" + i).show();

    } else {
        ++i;

        var new_i = i - 1;
        $(".error_msg" + new_i).hide();
        $(".asset_row:last")
            .after(` <div class="row asset_row test_row asset_div${i}">                         
            <div class="col-md-5">
                    <div class="form-group">
                        <select name="asset[${i}][section]" class="form-control section-select-box" id="section${i}">
                            <option value="">Select Section</option>
                            <option value="home">Home</option>
                            <option value="about_us">About Us</option>
                            <option value="menu">Menu</option>
                        </select>
                        <span class="section_error_msg${i} text-danger"></span>
                    </div>
              </div>
            <div class="col-md-5">
                <div class="form-group ">
                    <div class="custom-file">
                        <input type="file" name="asset[${i}][asset]" class="custom-file-input dropify${i}" data-id="${i}" id="asset${i}"
                            data-errors-position="outside" data-allowed-file-extensions='["jpg", "png","kpeg"]'
                            data-max-file-size="0.6M" data-height="25">
                    </div>
                    <span class="error_msg${i} text-danger"></span>
                </div>
            </div> 

            <div class="col-md-2">
                <div class="remove_row${i}" onclick="remove(${i})"><i class="mdi mdi-delete close_icon_add_form"></i></div>
            </div> 
        </div>`);
        $('.dropify' + i).dropify();
    }
}

function remove(id) {
    var length = $('.asset_row').length;
    if (length === 1) {
        $(".asset_div" + id).empty();
    } else {
        $(".asset_div" + id).remove();
    }

}




$(document).on('submit', '#restaurantAddForm', function(event) {
    event.preventDefault();
    var path = window.location.origin;
    $.ajax({
        url: path+'/admin/restaurants/store',
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success: function(response) {
            if (response.success == true) {
                if (response.data.message) {
                    $('.dropdown-menu').find('.restaurant_list:last').after(
                        `<a href="javascript:void(0);" data-id="${response.data.id}" id="restaurant_id${response.data.id}"
                        class="dropdown-item notify-item restaurant_list  restaurant">
                        ${response.data.name} </a>`
                    );
                    $('#RestaurantAdd').modal('hide');
                    toastMixin.fire({
                        icon: 'success',
                        animation: true,
                        title: "" + response.data.message + ""
                    });

                }
            } else {
                toastMixin.fire({
                    icon: 'error',
                    animation: true,
                    title: "" + response.data.error + ""
                });

            }
        }, //success end
        error: function(error) {
            if (error.status == 422) {
                $.each(error.responseJSON.errors, function(i, message) {
                    toastMixin.fire({
                        icon: 'error',
                        animation: true,
                        title: "" + message + ""
                    });
                });

            }
        },

    });
});

