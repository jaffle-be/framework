<?php namespace App\Providers;

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

        $router->model('image', 'App\Media\Image');
        $router->model('tag', 'App\Tags\Tag');
        $router->model('blog', 'App\Blog\Post');
        $router->model('address', 'App\Contact\Address');
        $router->model('account_contact_information', 'App\Account\AccountContactInformation');
        $router->model('portfolio', 'App\Portfolio\Project');
        $router->model('membership', 'App\Account\Membership');
        $router->model('menu', 'App\Menu\Menu');
        $router->model('menu-item', 'App\Menu\MenuItem');
        $router->model('skill', 'App\Users\Skill');
        $router->model('client', 'App\Account\Client');
        $this->pathsToPublish('');
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
