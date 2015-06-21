<?php namespace App\Shop\Http\Store;

use App\Http\Controllers\Controller;

class CheckoutController extends Controller{

    public function index()
    {
        return view('shop::checkout');
    }

}