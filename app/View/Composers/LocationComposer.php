<?php

namespace App\View\Composers;

use App\Models\ContactUs;
use App\Models\DeliveryLocation;
use Illuminate\View\View;

class LocationComposer {

    protected $locations;

    public function __construct() {
        $this->locations    = DeliveryLocation::all();
    }

    public function compose(View $view) {
        $view->with([
            'locations'    => $this->locations,
        ]);
    }
}