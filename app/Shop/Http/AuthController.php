<?php namespace App\Shop\Http;

use App\Http\Controllers\Controller;

class AuthController extends Controller{

    public function register()
    {
        return view('shop::register');
    }

    public function login()
    {
        return view('shop::login');
    }

}