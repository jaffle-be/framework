<?php namespace App\Users\Http\Auth;

use App\Http\Controllers\Controller;
use App\Users\Auth\Commands\Signup;
use App\Users\Auth\Requests\SignupRequest;
use App\Users\User;

class SignupController extends Controller
{

    public function index()
    {
        $user = new User();

        return $this->theme->render('auth.register', compact('user'));
    }

    public function store(SignupRequest $request)
    {
        $data = $request->only(array('email', 'password', 'password_confirmation'));

        if ($user = $this->dispatchFromArray(Signup::class, $data)) {
            return redirect()->route('store.home')->with('message', 'success');
        }

        return redirect()->back()->with('message', 'failed');
    }
}