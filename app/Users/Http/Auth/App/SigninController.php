<?php namespace App\Users\Http\Auth\App;

use App\Users\Http\Auth\SigninController as BaseController;

class SigninController extends BaseController
{

    public function routePrefix()
    {
        return 'app';
    }
}