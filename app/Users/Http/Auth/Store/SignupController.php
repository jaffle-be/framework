<?php namespace App\Users\Http\Auth\Store;

use App\Users\Http\Auth\SignupController as BaseController;

class SignupController extends BaseController
{

    public function routePrefix()
    {
        return 'store';
    }
}