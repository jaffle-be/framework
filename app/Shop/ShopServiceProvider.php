<?php namespace App\Shop;

use Illuminate\Support\ServiceProvider;

class ShopServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/Http/routes.php';

        //migration files
        $this->publishes([
            __DIR__ . '/database/migrations' => base_path('database/migrations')
        ]);

        //load translations and views
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'shop');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'shop');
        $this->mergeConfigFrom(__DIR__ . '/config/shops.php', 'shop');

        //event listeners
        $this->listeners();
	}

    /**
     * Register the application services.
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