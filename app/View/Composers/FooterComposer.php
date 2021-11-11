<?php

namespace App\View\Composers;

use App\Models\ContactUs;
use Illuminate\View\View;

class FooterComposer {

    protected $contactDetails;

    public function __construct() {
        $this->contactDetails    = ContactUs::first();
    }

    public function compose(View $view) {
        $view->with([
            'contactDetails'    => $this->contactDetails,
        ]);
    }
}