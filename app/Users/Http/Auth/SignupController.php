<?php namespace App\Users\Http\Auth;

use App\Http\Controllers\Controller;
use App\Users\Auth\Commands\Signup;
use App\Users\Auth\Requests\SignupRequest;
use App\Users\User;

abstract class SignupController extends Controller
{

    abstract function routePrefix();

    public function index()
    {
        $user = new User();

        return view('users::auth.register', compact('user'));
    }

    public function store(SignupRequest $request)
    {
        $data = $request->only(array('email', 'password', 'password_confirmation'));

        if ($user = $this->dispatchFromArray(Signup::class, $data)) {
            return redirect()->route($this->routePrefix() . '.home')->with('message', 'success');
        }

        return redirect()->back()->with('message', 'failed');
    }
}