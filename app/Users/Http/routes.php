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

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Users\Http\Auth\Store'], function () {

    Route::resource('signup', 'SignupController', ['as' => 'store', 'only' => ['index', 'store']]);
    Route::resource('confirm-email', 'ConfirmEmailController', ['as' => 'store', 'only' => ['show', 'create', 'store']]);
    Route::resource('signin', 'SigninController', ['as' => 'store', 'only' => ['index', 'store']]);
    Route::resource('signout', 'SignoutController', ['as' => 'store', 'only' => ['index']]);
    Route::resource('forgot-password', 'ForgotPasswordController', ['as' => 'store', 'only' => ['index', 'store']]);
    Route::resource('reset-password', 'ResetPasswordController', ['as' => 'store', 'only' => ['show', 'update']]);
});

Route::group(['namespace' => 'App\Users\Http\Auth\App'], function () {

    Route::resource('signup', 'SignupController', ['only' => ['index', 'store']]);
    Route::resource('confirm-email', 'ConfirmEmailController', ['only' => ['show', 'create', 'store']]);
    Route::resource('signin', 'SigninController', ['only' => ['index', 'store']]);
    Route::resource('signout', 'SignoutController', ['only' => ['index']]);
    Route::resource('forgot-password', 'ForgotPasswordController', ['only' => ['index', 'store']]);
    Route::resource('reset-password', 'ResetPasswordController', ['only' => ['show', 'update']]);
});