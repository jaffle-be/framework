<?php namespace App\Layout;

use Illuminate\Support\ServiceProvider;

class LayoutServiceProvider extends ServiceProvider{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        //include our routes
        include __DIR__ . '/Http/routes.php';

        //migration files
        $this->publishes([
            __DIR__ . '/database/migrations' => base_path('database/migrations')
        ]);

        //load translations and views
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'layout');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'layout');
        $this->mergeConfigFrom(__DIR__ . '/config/layout.php', 'layout');

        //event listeners
        $this->listeners();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    private function listeners()
    {
    }
}