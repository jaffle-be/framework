<?php namespace App\Users\Http\Auth;

use App\System\Http\Controller;
use App\Users\Auth\Commands\SendResetEmail;
use App\Users\Auth\Requests\ForgotPasswordRequest;
use Lang;

class ForgotPasswordController extends Controller
{

    public function index()
    {
        return $this->theme->render('auth.forgot-password');
    }

    public function store(ForgotPasswordRequest $request)
    {
        $this->dispatchFrom(SendResetEmail::class, $request);

        return redirect()->route('store.auth.signin.index')->withSuccess(Lang::get('users::front.request-handled'));
    }
}