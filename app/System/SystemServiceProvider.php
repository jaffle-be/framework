<?php

namespace App\System;


use Illuminate\Support\AggregateServiceProvider;

class SystemServiceProvider extends AggregateServiceProvider{

    protected $providers = [
        'App\System\Country\CountryServiceProvider',
    ];

}