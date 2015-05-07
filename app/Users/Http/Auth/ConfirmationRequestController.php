<?php namespace App\Users\Http\Auth;

class ConfirmationRequestController extends Controller
{
    public function getConfirmation()
    {
        return View::make('application.front.request-confirmation-email');
    }

    public function postConfirmation(RequestConfirmEmailRequest $request)
    {
        $data = $request->except('_token');

        $command = new RequestConfirmEmailCommand($data);

        return $this->bus->execute($command);
    }
}