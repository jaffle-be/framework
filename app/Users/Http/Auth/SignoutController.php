<?php namespace App\Users\Http\Auth;

use App\Http\Controllers\Controller;
use App\Users\Auth\Commands\Signout;

class SignoutController extends Controller{

    public function index()
    {
        $command = new Signout();

        $this->dispatch($command);

        return redirect()->route('home');
    }

}