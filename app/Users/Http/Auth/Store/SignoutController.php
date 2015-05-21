<?php namespace App\Users\Http\Auth\Store;

use App\Users\Http\Auth\SignoutController as BaseController;
use Lang;

class SignoutController extends BaseController
{

    public function routePrefix()
    {
        return 'store';
    }
}