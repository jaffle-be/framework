<?php

namespace Modules\Users\Auth\Commands;

use App\Jobs\Job;
use Illuminate\Contracts\Auth\Guard;

class Signout extends Job
{
    public function handle(Guard $guard)
    {
        $guard->logout();
    }
}
