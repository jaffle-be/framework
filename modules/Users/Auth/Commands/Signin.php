<?php

namespace Modules\Users\Auth\Commands;

use App\Jobs\Job;
use Illuminate\Contracts\Auth\Guard;
use Modules\Users\Contracts\Throttler;
use Modules\Users\Contracts\UserRepositoryInterface;

/**
 * Class Signin
 * @package Modules\Users\Auth\Commands
 */
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

    /**
     * @param $credentials
     * @param $remember_me
     */
    public function __construct($credentials, $remember_me)
    {
        $this->credentials = $credentials;
        $this->remember_me = $remember_me;
    }

    /**
     * @param Guard $auth
     * @param Throttler $throttler
     * @param UserRepositoryInterface $users
     * @return bool|\Illuminate\Contracts\Auth\Authenticatable|null|string
     */
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
                if (! $user || $user->confirmed == 1) {
                    $throttler->throttle($email);
                } else {
                    return 'unconfirmed';
                }
            }
        }

        return false;
    }

    /**
     * @return array
     */
    protected function getCredentialsForAttempt()
    {
        return array_merge($this->attemptingOptions, $this->credentials);
    }
}
