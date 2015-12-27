<?php

namespace Modules\Users\Auth\Commands;

use App\Jobs\Job;
use Illuminate\Contracts\Auth\Guard;
use Modules\Users\Contracts\Throttler;
use Modules\Users\Contracts\UserRepositoryInterface;

class Signin extends Job
{
    protected $credentials;

    protected $remember_me;

    /**
     * For security reasons, we only check for the following rules why an attempt failed.
     *
     * @var array
     */
    protected $possibleCauses = ['userUnconfirmed'];

    protected $attemptingOptions = ['confirmed' => 1];

    public function __construct($credentials, $remember_me)
    {
        $this->credentials = $credentials;
        $this->remember_me = $remember_me;
    }

    public function handle(Guard $auth, Throttler $throttler, UserRepositoryInterface $users)
    {
        $credentials = $this->getCredentialsForAttempt();

        //disallow to many attempts in to short time interval
        $email = $credentials['email'];

        if ($throttler->allows($email)) {
            if ($auth->attempt($credentials, $this->remember_me)) {
                return $auth->user();
            } else {
                $user = $users->findUserByEmail($email);

                //do not throttle when the user is still unconfirmed, so we can display a message
                if (!$user || $user->confirmed == 1) {
                    $throttler->throttle($email);
                } else {
                    return 'unconfirmed';
                }
            }
        }

        return false;
    }

    protected function getCredentialsForAttempt()
    {
        return array_merge($this->attemptingOptions, $this->credentials);
    }
}
