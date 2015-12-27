<?php

namespace Modules\Shop\Http;

use Modules\System\Http\FrontController;

class CheckoutController extends FrontController
{
    public function index()
    {
        return $this->theme->render('shop.checkout');
    }
}
