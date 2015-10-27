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
        $router->model('subesturi', 'Modules\System\Uri\Uri');
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
