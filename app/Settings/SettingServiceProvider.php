<?php namespace App\Settings;

use Jaffle\Tools\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{

    protected $namespace = 'setting';

    public function register()
    {

        if(config('settings.cache'))
        {
            $this->app->bind('App\Settings\Contracts\SettingsRepositoryInterface', function($app){
                $repository = $app->make('App\Settings\SettingsRepository');

                return new CachedSettingsRepository($repository);
            });
        }
        else{
            $this->app->bind('App\Settings\Contracts\SettingsRepositoryInterface', 'App\Settings\SettingsRepository');
        }
    }

    protected function observers()
    {
    }

    protected function listeners()
    {
    }
}