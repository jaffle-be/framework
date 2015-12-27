<?php

namespace Modules\Users\Auth\Handlers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Account\Jobs\Membership\AcceptMembership;
use Modules\Users\Auth\Commands\SendConfirmationEmail;
use Modules\Users\Auth\Events\UserRegistered;

/**
 * Class UserRegisteredHandler
 * @package Modules\Users\Auth\Handlers
 */
class UserRegisteredHandler
{
    use DispatchesJobs;

    /**
     * @param Mailer $mail
     * @param Repository $config
     */
    public function __construct(Mailer $mail, Repository $config)
    {
        $this->mail = $mail;
        $this->config = $config;
    }

    /**
     * @param UserRegistered $event
     * @return bool|mixed
     */
    public function handle(UserRegistered $event)
    {
        $auto_confirm = $this->config->get('users.auth.auto_confirmation');

        if ($event->invitation) {
            $event->user->confirmed = 1;
            $event->user->save();

            $this->dispatch(new AcceptMembership($event->invitation, $event->user));
        }

        if (! $auto_confirm['auth.auto_confirmation']) {
            //we need to send an email to confirm their email address.
            return $this->dispatch(new SendConfirmationEmail($event->user));
        }

        $event->user->confirmed = 1;

        return $event->user->save();
    }
}
