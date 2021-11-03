Pusher.logToConsole = true;
var pusher = new Pusher("1efc814744bed7686f5e", {
    cluster: "ap2",
});

var channel = pusher.subscribe("my-channel");
var id = $("#managerRestaurantId").val();

var audio = new Audio("http://127.0.0.1:8000/backend/assets/notification.mp3");

channel.bind("my-event", function (data) {
    // $("#sht1").text("click from pusher bind");

    if (id == data.restaurant_id) {
        $("#newOrders").html(data.message);
        $(".new_order_badge").html(data.message);
        $("#allNewOrderModal").modal("show");
        // playAudio();
        // audio.muted = true

        audio.play();
        audio.muted = false;
        // audio.muted = false
    }
});

// function playAudio() {
//     // Show loading animation.
//     var playPromise = x.play();

//     if (playPromise !== undefined) {
//         playPromise
//             .then((_) => {
//                 x.play();
//             })
//             .catch((error) => {
//                 console.log(error);
//             });
//     }
// }
