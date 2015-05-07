<?php namespace App\Users\Http\Auth;

use App\Http\Controllers\Controller;
use App\Users\Auth\Commands\Signup;
use App\Users\Auth\Requests\SignupRequest;
use App\Users\User;

class SignupController extends Controller{

    public function index()
    {
        $user = new User();

        return view('users::auth.signup', compact('user'));
    }

    public function store(SignupRequest $request)
    {
        $data = $request->only(array('email', 'password', 'password_confirmation'));

        if($user = $this->dispatchFromArray(Signup::class, $data))
        {
            return redirect()->route('home')->with('message', 'success');
        }

        return redirect()->back()->with('message', 'failed');
    }

}