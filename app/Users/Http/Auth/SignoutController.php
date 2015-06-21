<?php namespace App\Users\Http\Auth;

use App\Http\Controllers\Controller;
use App\Users\Auth\Commands\Signout;
use Lang;

abstract class SignoutController extends Controller
{

    abstract function routePrefix();

    public function index()
    {
        $command = new Signout();

        $this->dispatch($command);

        return redirect()->route($this->routePrefix() . '.signin.index')->withSuccess(Lang::get('users::general.logout_success'));
    }
}