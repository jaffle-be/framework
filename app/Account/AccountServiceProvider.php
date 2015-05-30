<?php namespace App\Account;

use Illuminate\Support\ServiceProvider;

class AccountServiceProvider extends ServiceProvider{

    public function boot()
    {
        //include our routes
        include __DIR__ . '/Http/routes.php';

        //migration files
        $this->publishes([
            __DIR__ . '/database/migrations' => base_path('database/migrations')
        ]);

        //load translations and views
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'accounts');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'accounts');
        $this->mergeConfigFrom(__DIR__ . '/config/accounts.php', 'accounts');

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