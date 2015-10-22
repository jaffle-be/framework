<?php namespace App\Shop\Http;

use App\System\Http\FrontController;

class AuthController extends FrontController{

    public function register()
    {
        return $this->theme->render('shop.register');
    }

    public function login()
    {
        return $this->theme->render('shop.login');
    }

}