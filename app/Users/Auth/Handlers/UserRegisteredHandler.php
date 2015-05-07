<?php namespace App\Users\Auth\Handlers;

use App\Users\Auth\Commands\SendConfirmationEmail;
use App\Users\Auth\Events\UserRegistered;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Bus\DispatchesCommands;

class UserRegisteredHandler
{

    use DispatchesCommands;

    public function __construct(Mailer $mail, Repository $config)
    {
        $this->mail = $mail;
        $this->config = $config;
    }

    public function handle(UserRegistered $event)
    {
        $config = $this->config->get('users');

        if(!$config['auth.auto_confirmation'])
        {
            //we need to send an email to confirm their email address.
            $this->dispatch(new SendConfirmationEmail($event->user));
        }
        else{
            $event->user->confirmed = 1;

            $event->user->save();
        }
    }
}