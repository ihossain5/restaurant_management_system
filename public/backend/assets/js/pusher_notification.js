      Pusher.logToConsole = true;
      var pusher = new Pusher('84269c4d437fd9489247', {
          cluster: 'ap2'
      });

      var channel = pusher.subscribe('my-channel');

      channel.bind('my-event', function(data) {
          //  Swal.fire(data.message)
          var number = parseInt($('.order_number').val());
          var new_number = number + 1;
          $('.numberOfNewOrder').html(new_number);
          $('.order_number').val(new_number);
          $('#notificationModal').modal('show');
          //  alert(number);
          playAudio();

      });



      function playAudio() {
          var x = new Audio('http://127.0.0.1:8000/backend/assets/notification.mp3');
          // Show loading animation.
          var playPromise = x.play();

          if (playPromise !== undefined) {
              playPromise.then(_ => {
                      x.play();
                      // Automatic playback started!
                      // Show playing UI.
                  })
                  .catch(error => {
                      console.log(error);
                      // Auto-play was prevented
                      // Show paused UI.
                  });

          }


      }