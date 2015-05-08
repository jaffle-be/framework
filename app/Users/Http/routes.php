<?php

Route::group(['namespace' => 'App\Users\Http\Auth'], function () {
    Route::resource('signup', 'SignupController', ['only' => ['index', 'store']]);
    Route::resource('confirm-email', 'ConfirmEmailController', ['only' => ['show', 'create', 'store']]);
    Route::resource('signin', 'SigninController', ['only' => ['index', 'store']]);
    Route::resource('signout', 'SignoutController', ['only' => ['index']]);
    Route::resource('forgot-password', 'ForgotPasswordController', ['only' => ['index', 'update']]);
    Route::resource('reset-password', 'ResetPasswordController', ['only' => ['index', 'update']]);
});
