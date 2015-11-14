<?php namespace Modules\Shop\Providers;

use Pingpong\Modules\ServiceProvider;

class ShopServiceProvider extends ServiceProvider
{

    protected $namespace = 'shop';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Modules\Shop\Product\CatalogRepositoryInterface', 'Modules\Shop\Product\CatalogRepository');
        $this->app->bind('Modules\Shop\Gamma\GammaRepositoryInterface', 'Modules\Shop\Gamma\GammaRepository');
    }

    protected function listeners()
    {
        $this->app['events']->listen('eloquent.attached: product_categories', 'Modules\Shop\Product\BrandCategoryManager@attach');
        $this->app['events']->listen('eloquent.detached: product_categories', 'Modules\Shop\Product\BrandCategoryManager@detach');

        $this->app['events']->listen('eloquent.attached: product_categories', 'Modules\Shop\Gamma\ProductCategoryManager@attach');
        $this->app['events']->listen('eloquent.detached: product_categories', 'Modules\Shop\Gamma\ProductCategoryManager@detach');
    }

    protected function observers()
    {

    }
}