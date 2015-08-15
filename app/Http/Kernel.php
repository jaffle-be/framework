<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'App\Http\Middleware\VerifyCsrfToken',

        //here we set the account for the current request.
        //we do not check validity of the account here,
        //since we want to be able to redirect the user to
        //a special section to reactivate their account.
        'App\Account\Http\Middleware\AccountMiddleware',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [

        /**
         * @todo most of these need implementation!
         */

        //check if the user is authenticated to access the admin area.
        'auth.admin'   => 'App\Http\Middleware\AuthenticateAdminArea',

        //check if the account is still active and so on.
        'auth.account' => 'App\Account\Http\AuthenticateAccount',

        //check if the user is still allowed in our app.
        'auth.user'    => 'App\Users\Http\AuthenticateUser',

        //check if current account and user has access to the requested module.
        'auth.module'  => 'App\Module\Http\AuthenticateModule',

        //authentication for an actual customer in the shopping module.
        'auth.shop'    => 'App\Shop\Http\AuthenticateCustomer',

        //redirect to the admin area when arriving on the homepage (not 100% sure).
        'guest'        => 'App\Http\Middleware\RedirectIfAuthenticated',
    ];

}
