<?php

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Dashboard\Http\Stores', 'prefix' => 'admin'], function () {

    Route::resource('start', 'DashboardController', ['only' => ['index']]);
});

Route::group(['namespace' => 'App\Dashboard\Http\App', 'prefix' => 'admin'], function () {

    Route::resource('start', 'DashboardController', ['only' => ['index']]);
});