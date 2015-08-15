<?php namespace App\Theme\Facade;

use Illuminate\Support\Facades\Facade;

class Theme extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'theme';
    }


}