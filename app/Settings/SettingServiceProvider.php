<?php namespace App\Settings;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('App\Settings\Contracts\SettingsRepositoryInterface', 'App\Settings\SettingsRepository');
    }

}