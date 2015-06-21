<?php namespace App\Users\Auth\Commands;

use App\Jobs\Job;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;

class Signout extends Job implements SelfHandling{

    public function handle(Guard $guard)
    {
        $guard->logout();
    }

}