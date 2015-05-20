<?php namespace App\Dashboard;

use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider{

    public function boot()
    {
        //include our routes
        include __DIR__ . '/Http/routes.php';

        //migration files
        $this->publishes([
            __DIR__ . '/database/migrations' => base_path('database/migrations')
        ]);

        //load translations and views
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'dashboard');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'dashboard');
        $this->mergeConfigFrom(__DIR__ . '/config/dashboard.php', 'dashboard');

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

    protected function listeners()
    {
    }
}