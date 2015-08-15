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

    public function __construct($email, $password, MembershipInvitation $invitation = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->invitation = $invitation;
    }

    public function handle(User $user, Hasher $hash, Dispatcher $events)
    {
        $connection = $user->getConnection();
        $connection->beginTransaction();

        try{
            $user->email = $this->email;
            $user->password = $hash->make($this->password);

            $user->save();

            $events->fire(new UserRegistered($user, $this->invitation));

            $connection->commit();

            return $user;
        }
        catch(Exception $e)
        {
            $connection->rollBack();
            throw $e;
        }
    }
}