<?php namespace App\Users\Http\Auth;

class ConfirmationController extends Controller{

    public function getConfirm($token)
    {
        return View::make('application.front.confirmation', compact('token'));
    }

    public function postConfirm(ConfirmEmailRequest $request, $token)
    {
        $data = array_merge(['token' => $token], $request->except('_token'));

        $command = new ConfirmEmailCommand($data);

        return $this->bus->execute($command);
    }

}