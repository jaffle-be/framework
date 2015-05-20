<?php

Route::group(['namespace' => 'App\Dashboard\Http\Admin', 'prefix' => 'admin'], function () {

    Route::resource('start', 'DashboardController', ['only' => ['index']]);
});