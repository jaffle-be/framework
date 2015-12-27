<?php

namespace Modules\Shop\Http;

use Modules\System\Http\FrontController;

/**
 * Class AuthController
 * @package Modules\Shop\Http
 */
class AuthController extends FrontController
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function register()
    {
        return $this->theme->render('shop.register');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function login()
    {
        return $this->theme->render('shop.login');
    }
}
