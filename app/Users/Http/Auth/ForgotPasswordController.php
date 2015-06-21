<?php namespace App\Users\Http\Auth;

use App\Http\Controllers\Controller;
use App\Users\Auth\Commands\SendResetEmail;
use App\Users\Auth\Requests\ForgotPasswordRequest;
use Lang;

abstract class ForgotPasswordController extends Controller
{

    abstract function routePrefix();

    public function index()
    {
        return view('users::auth.forgot-password');
    }

    public function store(ForgotPasswordRequest $request)
    {
        $this->dispatchFrom(SendResetEmail::class, $request);

        return redirect()->route($this->routePrefix() . '.signin.index')->withSuccess(Lang::get('users::general.request-handled'));
    }
}