// Cart Toggle Js
function cartToggle() {

    if (document.getElementById('trasnparentBg').style.display !== "block") {
        document.getElementById('cart').style.right = 0;
        document.getElementById('trasnparentBg').style.display = "block";
    } else {
        document.getElementById('cart').style.right = "-802px";
        document.getElementById('trasnparentBg').style.display = "none";
    }

}


function closeCart() {
    document.getElementById('cart').style.right = "-802px";
    document.getElementById('trasnparentBg').style.display = "none";
}


$('.passToggleLogin1Btn').click(function () {

    if ($(".loginPassword").attr("type") === "password") {
        $(".loginPassword").attr("type", "text");
        $('.passToggleLogin1Btn').html('Hide')
    } else {
        $(".loginPassword").attr("type", "password");
        $('.passToggleLogin1Btn').html('Show')
    }

})



function personalInfoEdit() {
    $('.personalInfo').addClass('d-none');
    $('.personalInfoForm').removeClass('d-none');

    $('.perosnalEditBtn').addClass('d-none')
}



function personalInfoSave() {
    $('.personalInfo').removeClass('d-none');
    $('.personalInfoForm').addClass('d-none');

    $('.perosnalEditBtn').removeClass('d-none')

}



function deliveryInfoEdit() {
    $('.deliveryInfo').addClass('d-none');
    $('.deliveryInfoForm').removeClass('d-none');

    $('.deliveryEditBtn').addClass('d-none');
}



function deliveryInfoSave() {
    $('.deliveryInfo').removeClass('d-none');
    $('.deliveryInfoForm').addClass('d-none');

    $('.deliveryEditBtn').removeClass('d-none');
}


$('.editBtnDeliveryInfo').click(function () {
    $('.deliveryInfoInput').removeClass('d-none');
    $('.deliveryInfo').addClass('d-none');
    $('.editBtnDeliveryInfo').addClass('d-none');

    $('.info-box1').css({
        "background": "transparent",
        "border": "none",
        "box-shadow": "none",
        "padding": "0"
    });


})


$('.deliveryInfoBtn').click(function () {
    $('.deliveryInfoInput').addClass('d-none');
    $('.deliveryInfo').removeClass('d-none');
    $('.editBtnDeliveryInfo').removeClass('d-none');

    $('.info-box1').css({
        "background": "#FFFFFF",
        "border": "1px solid #F2F2F2",
        "box-shadow": "4px 12px 60px rgba(0, 0, 0, 0.03)",
        "padding": "5.6rem",
    });
})


$('.editBtnAcountInfo').click(function () {
    $('.acountInfoInput').removeClass('d-none');
    $('.acountInfo').addClass('d-none');
    $('.editBtnAcountInfo').addClass('d-none');

    $('.info-box2').css({
        "background": "transparent",
        "border": "none",
        "box-shadow": "none",
        "padding": "0"
    });
})


$('.acountInfoBtn').click(function () {
    $('.acountInfoInput').addClass('d-none');
    $('.acountInfo').removeClass('d-none');
    $('.editBtnAcountInfo').removeClass('d-none');

    $('.info-box2').css({
        "background": "#FFFFFF",
        "border": "1px solid #F2F2F2",
        "box-shadow": "4px 12px 60px rgba(0, 0, 0, 0.03)",
        "padding": "5.6rem",
    });
})

// edit profile image 
$('#fileUpload').change(function() {
    const url = window.URL.createObjectURL(this.files[0]);
    $('#uplodedImg').attr('src', url);
})

var locationModal = new bootstrap.Modal(document.getElementById('location-modal'), {
    keyboard: false
})

$(document).ready(function () {
        // location modal close btn
        $('.lmbCloseBtn').hide();
        $('.addTocart').hide();
    locationID = document.getElementById("select_id").value;
    
    if(locationID != ''){
        $('.lmbCloseBtn').show();
    }else{
        locationModal.show();
    }
    
})

$('.navbar-toggler').on('click', function() {
    $('body').toggleClass('active');
})