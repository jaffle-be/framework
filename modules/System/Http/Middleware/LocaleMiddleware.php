<?php

namespace Modules\System\Http\Middleware;

use Closure;
use Illuminate\Cookie\CookieJar;
use Illuminate\Session\Store;

/**
 * Class LocaleMiddleware
 * @package Modules\System\Http\Middleware
 */
class LocaleMiddleware
{
    /**
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return
     */
    public function handle($request, Closure $next)
    {
        //on the front, locale is determined by either:
        // - multi locale -> url prefix
        // - single locale -> from config

        if (on_front()) {
            $request = app('request');

            if (env('APP_MULTIPLE_LOCALES')) {
                $locale = $request->segment(1);

                //if invalid locale
                if (empty($locale) || ! in_array($locale, config('system.locales'))) {
                    //use the current default locale
                    $locale = app()->getLocale();
                }

                app()->setLocale($locale);

                /* @var CookieJar $cookies */

                if (! $request->hasCookie('locale') && $request->getRequestUri() != '/') {
                    $cookies = app('cookie');
                    cookie()->queue(cookie()->forever('locale', $locale));
                }
            }
        } elseif ($this->session->has('locale')) {
            app()->setLocale($this->session->get('locale'));
        }

        return $next($request);
    }
}
