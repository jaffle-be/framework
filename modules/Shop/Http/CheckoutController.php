<?php

namespace Modules\Shop\Http;

use Modules\System\Http\FrontController;

/**
 * Class CheckoutController
 * @package Modules\Shop\Http
 */
class CheckoutController extends FrontController
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->theme->render('shop.checkout');
    }
}
