<?php

namespace Modules\System\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Session\TokenMismatchException;

/**
 * Class VerifyCsrfToken
 * @package Modules\System\Http\Middleware
 */
class VerifyCsrfToken extends BaseVerifier
{
    /**
     * Handle an incoming request.
     *
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
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
