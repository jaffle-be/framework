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
        app('router')->get('{uri}/{suburi?}/{subesturi?}', 'App\System\Http\UriController@handle');
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