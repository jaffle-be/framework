<?php namespace App\Users\Auth\Commands;

use App\Commands\Command;
use App\Users\Auth\Events\UserRegistered;
use App\Users\User;
use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Events\Dispatcher;

class Signup extends Command implements SelfHandling
{

    protected $email;

    protected $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function handle(User $user, Hasher $hash, Dispatcher $events)
    {
        $connection = $user->getConnection();
        $connection->beginTransaction();

        try{
            $user->email = $this->email;
            $user->password = $hash->make($this->password);

            $user->save();

            $events->fire(new UserRegistered($user));

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