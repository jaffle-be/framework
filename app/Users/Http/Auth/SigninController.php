<?php namespace App\Users\Http\Auth;

use App\Http\Controllers\Controller;
use App\Users\Auth\Commands\Signin;
use App\Users\Auth\Requests\SigninRequest;
use App\Users\User;
use Illuminate\Translation\Translator;

class SigninController extends Controller{

    public function index()
    {
        return view('users::auth.login');
    }

    public function store(SignInRequest $request, Translator $lang)
    {
        $credentials = $request->except('_token', 'remember_me');

        $remember_me = $request->has('remember_me') ? true : false;

        $response = $this->dispatchFromArray(Signin::class, compact('credentials', 'remember_me'));

        if($response instanceof User)
        {
            return redirect()->route('start');
        }
        else if(is_string($response) && $response == 'unconfirmed')
        {
            $route = route('confirm-email.create', ['email' => $credentials['email']]);

            $error = $lang->get('users::auth.errors.unconfirmed', ['url' => $route]);

            return redirect()->back()->withErrors(['email' => $error]);
        }

        return redirect()->back()->withErrors(['email' => $lang->get('users::auth.errors.failed')]);
    }

}