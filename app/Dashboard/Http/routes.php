<?php

/**
 * templates stores
 */
Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Dashboard\Http\Stores', 'prefix' => 'templates/admin'], function () {
    Route::resource('start', 'DashboardController', ['only' => ['index']]);
});

/**
 * Templates app
 */

Route::group(['namespace' => 'App\Dashboard\Http\App', 'prefix' => 'templates/admin'], function () {

    Route::resource('start', 'DashboardController', ['only' => ['index']]);
});