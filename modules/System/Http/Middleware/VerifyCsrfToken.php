<?php

namespace Modules\System\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     * @throws TokenMismatchException
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $exception) {
            if ($request->ajax()) {
                return response('stop juggling with my token!', 403);
            }

            throw $exception;
        }
    }
}
