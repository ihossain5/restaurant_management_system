Pusher.logToConsole = true;
var pusher = new Pusher("1efc814744bed7686f5e", {
    cluster: "ap2",
});

var channel = pusher.subscribe("my-channel");
var id = $("#managerRestaurantId").val();

channel.bind("my-event", function (data) {
    if(id == data.restaurant_id){
        $("#newOrders").html(data.message);
        $(".new_order_badge").html(data.message);
        $("#allNewOrderModal").modal("show");
        playAudio();
    }

});

function playAudio() {
    var x = new Audio("http://127.0.0.1:8000/backend/assets/notification.mp3");
    // Show loading animation.
    var playPromise = x.play();

    if (playPromise !== undefined) {
        playPromise
            .then((_) => {
                x.play();
            })
            .catch((error) => {
                console.log(error);
            });
    }
}
