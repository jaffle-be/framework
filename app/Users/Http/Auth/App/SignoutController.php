<?php namespace App\Users\Http\Auth\App;

use App\Users\Http\Auth\SignoutController as BaseController;
use Lang;

class SignoutController extends BaseController
{

    public function routePrefix()
    {
        return 'app';
    }
}