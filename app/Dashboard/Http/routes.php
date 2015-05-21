<?php

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Dashboard\Http\Admin', 'prefix' => 'admin'], function () {

    Route::resource('start', 'DashboardController', ['only' => ['index']]);
});