<?php namespace App\Contact;

use Illuminate\Support\ServiceProvider;

class ContactServiceProvider extends ServiceProvider{

    public function boot()
    {
        //include our routes
        include __DIR__ . '/Http/routes.php';

        //migration files
        $this->publishes([
            __DIR__ . '/database/migrations' => base_path('database/migrations')
        ]);

        //load translations and views
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'contact');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'contact');
        $this->mergeConfigFrom(__DIR__ . '/config/contact.php', 'contact');

        //event listeners
        $this->listeners();
    }

    public function register()
    {

    }

    protected function listeners()
    {
    }
}