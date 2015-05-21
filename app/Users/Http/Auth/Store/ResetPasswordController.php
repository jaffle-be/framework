<?php namespace App\Users\Http\Auth\Store;

use App\Users\Http\Auth\ResetPasswordController as BaseController;
use Lang;

class ResetPasswordController extends BaseController
{

    public function routePrefix()
    {
        return 'store';
    }
}