<?php namespace App\Users\Http\Auth\Store;

use App\Users\Http\Auth\ConfirmEmailController as BaseController;

class ConfirmEmailController extends BaseController
{

    public function routePrefix()
    {
        return 'store';
    }
}
