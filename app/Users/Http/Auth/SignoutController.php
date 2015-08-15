<?php namespace App\Users\Http\Auth;

use App\System\Http\Controller;
use App\Users\Auth\Commands\Signout;
use Lang;

class SignoutController extends Controller
{

    public function index()
    {
        $command = new Signout();

        $this->dispatch($command);

        return redirect()->route('store.auth.signin.index')->withSuccess(Lang::get('users::general.logout_success'));
    }
}