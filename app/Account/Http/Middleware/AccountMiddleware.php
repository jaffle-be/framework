<?php

namespace App\Account\Http\Middleware;

use App\Account\AccountManager;
use Closure;
use Illuminate\Http\Request;

class AccountMiddleware {

    protected $manager;

    public function __construct(AccountManager $manager)
    {
        $this->manager = $manager;
    }

    public function handle(Request $request, Closure $next)
    {
        $this->manager->boot($request);

        return $next($request);
    }

}