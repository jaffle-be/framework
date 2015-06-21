<?php namespace App\Users\Http\Auth\Store;

use App\Users\Http\Auth\ForgotPasswordController as BaseController;
use Lang;

class ForgotPasswordController extends BaseController
{

    public function routePrefix()
    {
        return 'store';
    }
}