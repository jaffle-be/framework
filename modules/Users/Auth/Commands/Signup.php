<?php

namespace Modules\Users\Auth\Commands;

use App\Jobs\Job;
use Exception;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Events\Dispatcher;
use Modules\Account\MembershipInvitation;
use Modules\Users\Auth\Events\UserRegistered;
use Modules\Users\User;

/**
 * Class Signup
 * @package Modules\Users\Auth\Commands
 */
class Signup extends Job
{
    protected $email;

    protected $password;

    protected $invitation;

    protected $user;

    /**
     * @param $email
     * @param $password
     * @param MembershipInvitation|null $invitation
     * @param User|null $user
     */
    public function __construct($email, $password, MembershipInvitation $invitation = null, User $user = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->invitation = $invitation;
        $this->user = $user;
    }

    /**
     * @param User $user
     * @param Hasher $hash
     * @param Dispatcher $events
     * @return User
     * @throws Exception
     */
    public function handle(User $user, Hasher $hash, Dispatcher $events)
    {
        $connection = $user->getConnection();
        $connection->beginTransaction();

        //we already have a user with this email.
        try {
            if (! $this->user) {
                $this->user = $user;
                $this->user->email = $this->email;
                $this->user->password = $hash->make($this->password);
                $this->user->save();
            }

            $events->fire(new UserRegistered($this->user, $this->invitation));

            $connection->commit();

            return $this->user;
        } catch (Exception $e) {
            $connection->rollBack();
            throw $e;
        }
    }
}
