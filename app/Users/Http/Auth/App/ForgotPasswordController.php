<?php namespace App\Users\Http\Auth\App;

use App\Users\Http\Auth\ForgotPasswordController as BaseController;
use Lang;

class ForgotPasswordController extends BaseController
{

    public function routePrefix()
    {
        return 'app';
    }
}