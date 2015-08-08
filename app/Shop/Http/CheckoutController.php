<?php namespace App\Shop\Http;

use App\System\Http\Controller;

class CheckoutController extends Controller{

    public function index()
    {
        return $this->theme->render('shop.checkout');
    }

}