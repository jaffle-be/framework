<?php namespace App\Shop\Http;

use App\System\Http\FrontController;

class CheckoutController extends FrontController{

    public function index()
    {
        return $this->theme->render('shop.checkout');
    }

}