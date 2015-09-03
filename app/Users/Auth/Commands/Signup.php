<?php namespace App\Users\Auth\Commands;

use App\Account\MembershipInvitation;
use App\Jobs\Job;
use App\Users\Auth\Events\UserRegistered;
use App\Users\User;
use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Events\Dispatcher;

class Signup extends Job implements SelfHandling
{

    protected $email;

    protected $password;

    protected $invitation;

    protected $user;

    public function __construct($email, $password, MembershipInvitation $invitation = null, User $user)
    {
        $this->email = $email;
        $this->password = $password;
        $this->invitation = $invitation;
        $this->user = $user;
    }

    public function handle(User $user, Hasher $hash, Dispatcher $events)
    {
        $connection = $user->getConnection();
        $connection->beginTransaction();

        //we allready have a user with this email.
        try {

            if (!$this->user) {
                $this->user = $user;
                $this->user->email = $this->email;
                $this->user->password = $hash->make($this->password);
                $this->user->save();
            }

            $events->fire(new UserRegistered($this->user, $this->invitation));

            $connection->commit();

            return $this->user;
        }
        catch (Exception $e) {
            $connection->rollBack();
            throw $e;
        }
    }
}