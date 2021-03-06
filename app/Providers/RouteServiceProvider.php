<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->model('image', 'Modules\Media\Image');
        $router->model('video', 'Modules\Media\Video\Video');
        $router->model('infographic', 'Modules\Media\Infographics\Infographic');
        $router->model('file', 'Modules\Media\Files\File');
        $router->model('tag', 'Modules\Tags\Tag');
        $router->model('pages', 'Modules\Pages\Page');
        $router->model('page', 'Modules\Pages\PageTranslation');
        $router->model('blog', 'Modules\Blog\Post');
        $router->model('post', 'Modules\Blog\PostTranslation');
        $router->model('address', 'Modules\Contact\Address');
        $router->model('account_contact_information', 'Modules\Account\AccountContactInformation');
        $router->model('portfolio', 'Modules\Portfolio\Project');
        $router->model('project', 'Modules\Portfolio\ProjectTranslation');
        $router->model('membership', 'Modules\Account\Membership');
        $router->model('menu', 'Modules\Menu\Menu');
        $router->model('menu-item', 'Modules\Menu\MenuItem');
        $router->model('skill', 'Modules\Users\Skill');
        $router->model('client', 'Modules\Account\Client');
        $router->model('tags', 'Modules\Tags\Tag');
        $router->model('uri', 'Modules\System\Uri\Uri');
        $router->model('suburi', 'Modules\System\Uri\Uri');
        $router->model('product', 'Modules\Shop\Product\ProductTranslation');
        $router->model('products', 'Modules\Shop\Product\Product');
        $router->model('properties', 'Modules\Shop\Product\Property');
        $router->model('groups', 'Modules\Shop\Product\PropertyGroup');
        $router->model('values', 'Modules\Shop\Product\PropertyValue');
        $router->model('options', 'Modules\Shop\Product\PropertyOption');
        $router->model('units', 'Modules\Shop\Product\PropertyUnit');
        $router->model('category', 'Modules\Shop\Product\CategoryTranslation');
        $router->model('brand', 'Modules\Shop\Product\BrandTranslation');
        $router->model('selections', 'Modules\Shop\Gamma\ProductSelection');

        $router->model('campaign', 'Modules\Marketing\Newsletter\Campaign');
        $router->model('campaign-widget', 'Modules\Marketing\Newsletter\CampaignWidget');

//        $this->pathsToPublish('');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
