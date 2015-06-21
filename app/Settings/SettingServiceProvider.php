<?php namespace App\Settings;

use Jaffle\Tools\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{

    protected $namespace = 'setting';

    public function register()
    {
        $this->app->bind('App\Settings\Contracts\SettingsRepositoryInterface', 'App\Settings\SettingsRepository');
    }

    protected function observers()
    {
    }

    protected function listeners()
    {
    }
}