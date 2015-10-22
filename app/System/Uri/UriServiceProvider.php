<?php namespace App\System\Uri;

use Illuminate\Support\ServiceProvider;

class UriServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        //this is only meant to handle wildcard routes to the defined uris in our uri table
        //we made a service provider to keep at the bottom of our provider inclusions (in config/app.php)
        //if we didn't do this, this smart route would overwrite about any route we had defined elsewhere.

        if(env('APP_MULTIPLE_LOCALES'))
        {
            foreach(config('system.locales') as $locale)
            {
                app('router')->group(['as' => 'store.'], function($router) use ($locale){
                    $router->get("$locale/{uri}/{suburi?}/{subesturi?}", ['uses' => 'App\System\Http\UriController@handle', 'as' => "$locale.uri.show"]);
                });
            }
        }
        else{
            app('router')->group(['as' => 'store.'], function($router){
                $router->get('{uri}/{suburi?}/{subesturi?}', ['uses' => 'App\System\Http\UriController@handle', 'as' => 'uri.show']);
            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

}