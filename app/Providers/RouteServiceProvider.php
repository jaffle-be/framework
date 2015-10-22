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
        $router->model('video', 'App\Media\Video\Video');
        $router->model('infographic', 'App\Media\Infographics\Infographic');
        $router->model('file', 'App\Media\Files\File');
        $router->model('tag', 'App\Tags\Tag');
        $router->model('pages', 'App\Pages\Page');
        $router->model('page', 'App\Pages\PageTranslation');
        $router->model('blog', 'App\Blog\Post');
        $router->model('post', 'App\Blog\PostTranslation');
        $router->model('address', 'App\Contact\Address');
        $router->model('account_contact_information', 'App\Account\AccountContactInformation');
        $router->model('portfolio', 'App\Portfolio\Project');
        $router->model('project', 'App\Portfolio\ProjectTranslation');
        $router->model('membership', 'App\Account\Membership');
        $router->model('menu', 'App\Menu\Menu');
        $router->model('menu-item', 'App\Menu\MenuItem');
        $router->model('skill', 'App\Users\Skill');
        $router->model('client', 'App\Account\Client');
        $router->model('tags', 'App\Tags\Tag');
        $router->model('uri', 'App\System\Uri\Uri');
        $router->model('suburi', 'App\System\Uri\Uri');
        $router->model('subesturi', 'App\System\Uri\Uri');
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
