<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <h1 class=""></h1>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;
    var pusher = new Pusher('1efc814744bed7686f5e', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    
    channel.bind('my-event', function(data) {
        $(`#new_call`).html(JSON.stringify(data.message));
    });
  

  </script>
</head>
<body>
    <p id="new_call"></p>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
</body>