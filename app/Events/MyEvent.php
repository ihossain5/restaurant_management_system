<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MyEvent implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $restaurant_id;

    public function __construct($message, $restaurant_id) {
        $this->message       = $message;
        $this->restaurant_id = $restaurant_id;
    }

    public function broadcastOn() {
        return ['my-channel'];
    }

    public function broadcastAs() {
        return 'my-event';
    }
}
