<?php namespace App\Users\Http\Auth;

/**
 * This class will allow a user to request a new confirmation email
 * Not the most used feature, but a rather important considering user friendlyness.
 * Signin up is an important step and should work without a hassle.
 *
 * Class ConfirmationRequestController
 *
 * @package App\Users\Http\Auth
 */
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