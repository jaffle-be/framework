<?php namespace App\Users\Http\Auth\App;

use App\Users\Http\Auth\ConfirmEmailController as BaseController;

class ConfirmEmailController extends BaseController
{

    public function routePrefix()
    {
        return 'app';
    }
}
