<?php namespace Modules\Shop\Providers;

use Modules\Shop\Product\Category;
use Modules\Shop\Product\CategoryTranslation;
use Modules\Shop\Product\Property;
use Modules\Shop\Product\PropertyGroup;
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

        $this->app['events']->listen('eloquent.detached: product_categories', 'Modules\Shop\Product\ProductPropertyManager@detach');

        $this->app['events']->listen('eloquent.saved: ' . CategoryTranslation::class, 'Modules\Shop\Product\CategorySuggestSyncer@handle');

        $this->app['events']->listen('eloquent.creating: ' . PropertyGroup::class, 'Modules\Shop\Product\PropertyObserver@creatingGroup');
        $this->app['events']->listen('eloquent.deleted: ' . PropertyGroup::class, 'Modules\Shop\Product\PropertyObserver@deletedGroup');

        $this->app['events']->listen('eloquent.creating: ' . Property::class, 'Modules\Shop\Product\PropertyObserver@creatingProperty');
        $this->app['events']->listen('eloquent.deleted: ' . Property::class, 'Modules\Shop\Product\PropertyObserver@deletedProperty');
    }

}