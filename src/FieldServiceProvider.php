<?php

namespace Seche\NovaJstree;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('jstree', __DIR__.'/../dist/js/field.js');
            Nova::style('jstree', __DIR__.'/../dist/css/field.css');
            Nova::translations(__DIR__.'/../resources/lang/'.app()->getLocale().'.json');
        });
        $this->publishes([
            __DIR__.'/../dist/images/vendor/jstree/dist/themes/default/' => public_path('images/vendor/jstree/dist/themes/default/'),
            __DIR__.'/../dist/images/vendor/jstree/dist/themes/default-dark/' => public_path('images/vendor/jstree/dist/themes/default-dark/')
        ], 'jstree-images');

        $this->publishes([
            __DIR__.'/../dist/fonts/vendor/@fortawesome/fontawesome-free/' => public_path('fonts/vendor/@fortawesome/fontawesome-free/'),
       ], 'jstree-fonts');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
