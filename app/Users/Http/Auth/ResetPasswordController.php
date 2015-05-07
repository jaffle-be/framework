<?php namespace App\Users\Http\Auth;

use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller{

    public function edit($token)
    {
        dd($token);

        return View::make('application.front.reset-password', compact('token'));
    }

    public function update($token = null)
    {
//        $data = array_merge(['token' => $token], $request->except('_token'));
//
//        $command = new ResetPasswordCommand($data);
//
//        return $this->bus->execute($command);
    }

}