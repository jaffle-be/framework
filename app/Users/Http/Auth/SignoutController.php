<?php namespace App\Users\Http\Auth;

use App\System\Http\FrontController;
use App\Users\Auth\Commands\Signout;
use Lang;

class SignoutController extends FrontController
{

    public function index()
    {
        $command = new Signout();

        $this->dispatch($command);

        return redirect()->to(store_route('store.auth.signin.index'))->withSuccess(Lang::get('users::front.logout-success'));
    }
}