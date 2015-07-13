<?php

namespace App\System;

use Jaffle\Tools\ServiceProvider;

class SystemServiceProvider extends ServiceProvider{

    protected $namespace = 'system';

    public function boot()
    {
        $this->validators();
        parent::boot();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    protected function observers()
    {
    }

    protected function listeners()
    {
    }

    protected function validators()
    {
        $this->app->make('validator')->extend('vat', 'App\System\Validators\Vat@validate');
    }

}