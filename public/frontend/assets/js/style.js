// Cart Toggle Js
let cartItems = $('.cartCounter').html();
if(cartItems ==0){
    $('.cartItems').attr('title','Cart is empty');
}else{
    $('.cartItems').removeAttr('title');
}

function cartToggle() {
    let cartItems = $('.cartCounter').html();
    if(cartItems >0){
        if (document.getElementById('trasnparentBg').style.display !== "block") {
            document.getElementById('cart').style.right = 0;
            document.getElementById('trasnparentBg').style.display = "block";
           
        } else {
            document.getElementById('cart').style.right = "-802px";
            document.getElementById('trasnparentBg').style.display = "none";
        }
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

    var name =  $('.customerName').html();
    var email =  $('.customerEmail').html();
    $('.customerNameEdit').val(name);
    $('.customerEmailEdit').val(email);
}



// function personalInfoSave() {
//     $('.personalInfo').removeClass('d-none');
//     $('.personalInfoForm').addClass('d-none');

//     $('.perosnalEditBtn').removeClass('d-none')

// }



function deliveryInfoEdit() {
    $('.deliveryInfo').addClass('d-none');
    $('.deliveryInfoForm').removeClass('d-none');
    $('.deliveryEditBtn').addClass('d-none');

   var address =  $('.customerAddress').html();
   var contact =  $('.customerContact').html();
   $('.customerAddressEdit').val(address);
   $('.customerContactEdit').val(contact);
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


// $('.deliveryInfoBtn').click(function (e) {
//     e.preventDefault();
//     e.stopPropagation();
//     $('.deliveryInfoInput').addClass('d-none');
//     $('.deliveryInfo').removeClass('d-none');
//     $('.editBtnDeliveryInfo').removeClass('d-none');

//     $('.info-box1').css({
//         "background": "#FFFFFF",
//         "border": "1px solid #F2F2F2",
//         "box-shadow": "4px 12px 60px rgba(0, 0, 0, 0.03)",
//         "padding": "5.6rem",
//     });
// })


$('.editBtnAcountInfo').click(function (e) {
    e.stopPropagation();
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


// $('.acountInfoBtn').click(function () {
//     $('.acountInfoInput').addClass('d-none');
//     $('.acountInfo').removeClass('d-none');
//     $('.editBtnAcountInfo').removeClass('d-none');

//     $('.info-box2').css({
//         "background": "#FFFFFF",
//         "border": "1px solid #F2F2F2",
//         "box-shadow": "4px 12px 60px rgba(0, 0, 0, 0.03)",
//         "padding": "5.6rem",
//     });
// })




$(document).ready(function () {
        // location modal close btn
        // $('.lmbCloseBtn').hide();
        $('.addTocart').hide();
        $('.closed').hide();

})

$('.navbar-toggler').on('click', function() {
    $('body').toggleClass('active');
})


// Carousel slide drag change
$(".carousel").swipe({
    swipe: function (event, direction, distance, duration, fingerCount, fingerData) {
        if (direction == 'left') $(this).carousel('next');
        if (direction == 'right') $(this).carousel('prev');
    },
    allowPageScroll: "vertical"
});


// Enable Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})