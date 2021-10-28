

Pusher.logToConsole = true;
var pusher = new Pusher("1efc814744bed7686f5e", {
    cluster: "ap2",
});

var channel = pusher.subscribe("my-channel");
var id = $("#managerRestaurantId").val();

channel.bind("my-event", function (data) {
    $("body").trigger("click");
    
    if(id == data.restaurant_id){
        $("#newOrders").html(data.message);
        $(".new_order_badge").html(data.message);
        $("#allNewOrderModal").modal("show");
        // playAudio();
        // audio.muted = true
        
        audio.play();
        // audio.muted = false

    }

});

function playAudio() {
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

