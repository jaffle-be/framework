<?php

namespace Modules\Users\Http\Auth;

use Lang;
use Modules\System\Http\FrontController;
use Modules\Users\Auth\Commands\SendResetEmail;
use Modules\Users\Auth\Requests\ForgotPasswordRequest;

/**
 * Class ForgotPasswordController
 * @package Modules\Users\Http\Auth
 */
class ForgotPasswordController extends FrontController
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->theme->render('auth.forgot-password');
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return mixed
     */
    public function store(ForgotPasswordRequest $request)
    {
        $this->dispatch(new SendResetEmail($request->get('email')));

        return redirect()->to(store_route('store.auth.signin.index'))->withSuccess(Lang::get('users::front.request-handled'));
    }
}
