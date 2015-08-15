<?php namespace App\Shop\Http;

use App\System\Http\Controller;

class AuthController extends Controller{

    public function register()
    {
        return $this->theme->render('shop.register');
    }

    public function login()
    {
        return $this->theme->render('shop.login');
    }

}