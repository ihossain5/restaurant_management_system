<?php

namespace App\Providers;


use App\View\Composers\CartComposer;
use App\View\Composers\FooterComposer;
use App\View\Composers\LocationComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['layouts.frontend.partials.cart','frontend.checkout.checkout'], CartComposer::class);
        View::composer(['layouts.frontend.partials.footer'], FooterComposer::class);
        View::composer(['layouts.frontend.partials.location_modal'], LocationComposer::class);
    }
}
