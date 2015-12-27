<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        'Fideloper\Proxy\TrustProxies',

        //here we set the account for the current request.
        //we do not check validity of the account here,
        //since we want to be able to redirect the user to
        //a special section to reactivate their account.

        \Modules\System\Http\Middleware\HttpsProtocol::class,
        \Modules\Account\Http\Middleware\AccountMiddleware::class,
        \Modules\System\Http\Middleware\LocaleMiddleware::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Modules\System\Http\Middleware\VerifyCsrfToken::class,
        ],
        'api' => [
//            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [

        /*
         * @todo most of these need implementation!
         */
//
//        //check if the user is authenticated to access the admin area.
        'auth.admin'   => Middleware\AuthenticateAdminArea::class,
//
//        //check if the account is still active and so on.
//        'auth.account' => 'App\Account\Http\AuthenticateAccount',
//
//        //check if the user is still allowed in our app.
//        'auth.user'    => 'App\Users\Http\AuthenticateUser',
//
//        //check if current account and user has access to the requested module.
//        'auth.module'  => 'App\Module\Http\AuthenticateModule',
//
//        //authentication for an actual customer in the shopping module.
//        'auth.shop'    => 'App\Shop\Http\AuthenticateCustomer',
//
//        //redirect to the admin area when arriving on the homepage (not 100% sure).
//        'guest'        => 'App\Http\Middleware\RedirectIfAuthenticated',
//
//
//
//        'auth' => \App\Http\Middleware\Authenticate::class,
//        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
//        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
//        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
