<?php namespace App\Shop\Http;

use App\Http\Controllers\Controller;

class CheckoutController extends Controller{

    public function index()
    {
        return view('shop::checkout');
    }

}