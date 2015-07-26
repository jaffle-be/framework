<?php

/**
 * Authentication can use the same controller each time, since we always use the same users table
 * The controllers themselves will redirect to the proper locations.
 *
 * all these routes represent routes that should handle authorization for access to admin areas.
 *
 * the subdomained ones are for the stores.
 * the regular one is for our native app.
 */
Route::group([
    'namespace' => 'App\Users\Http\Auth',
    'as'        => 'store.',
], function () {

    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::resource('signup', 'SignupController', ['only' => ['index', 'store']]);
        Route::resource('confirm-email', 'ConfirmEmailController', ['only' => ['show', 'create', 'store']]);
        Route::resource('signin', 'SigninController', ['only' => ['index', 'store']]);
        Route::resource('signout', 'SignoutController', ['only' => ['index']]);
        Route::resource('forgot-password', 'ForgotPasswordController', ['only' => ['index', 'store']]);
        Route::resource('reset-password', 'ResetPasswordController', ['only' => ['show', 'update']]);
    });
});