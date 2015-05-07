<?php namespace App\Users\Auth\Commands;

use App\Commands\Command;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;

class Signout extends Command implements SelfHandling{

    public function handle(Guard $guard)
    {
        $guard->logout();
    }

}