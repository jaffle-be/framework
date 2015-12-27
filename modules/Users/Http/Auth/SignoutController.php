<?php

namespace Modules\Users\Http\Auth;

use Lang;
use Modules\System\Http\FrontController;
use Modules\Users\Auth\Commands\Signout;

/**
 * Class SignoutController
 * @package Modules\Users\Http\Auth
 */
class SignoutController extends FrontController
{
    /**
     * @return mixed
     */
    public function index()
    {
        $command = new Signout();

        $this->dispatch($command);

        return redirect()->to(store_route('store.auth.signin.index'))->withSuccess(Lang::get('users::front.logout-success'));
    }
}
