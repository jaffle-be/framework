<?php namespace Modules\Users\Http\Auth;

use Illuminate\Translation\Translator;
use Modules\System\Http\FrontController;
use Modules\Users\Auth\Commands\Signin;
use Modules\Users\Auth\Requests\SigninRequest;
use Modules\Users\User;

class SigninController extends FrontController
{

    public function index()
    {
        return $this->theme->render('auth.login');
    }

    public function store(SignInRequest $request, Translator $lang)
    {
        $credentials = $request->except('_token', 'remember_me');

        $remember_me = $request->has('remember_me') ? true : false;

        $response = $this->dispatchFromArray(Signin::class, compact('credentials', 'remember_me'));

        if ($response instanceof User) {
            return redirect('admin/start');
        } else if (is_string($response) && $response == 'unconfirmed') {
            $route = store_route('store.auth.confirm-email.create', ['email' => $credentials['email']]);

            $error = $lang->get('users::auth.errors.unconfirmed', ['url' => $route]);

            return redirect()->back()->withErrors(['email' => $error]);
        }

        return redirect()->back()->withErrors(['email' => $lang->get('users::auth.errors.failed')]);
    }
}