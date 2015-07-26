<?php

/**
 * templates stores
 */
Route::group([
    'namespace' => 'App\Dashboard\Http',
    'as' => 'store.',
], function () {

    Route::group(['prefix' => 'templates'], function()
    {
        Route::resource('admin/start', 'Admin\DashboardController', ['only' => ['index']]);
    });

});