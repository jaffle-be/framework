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

    Route::get('/', [
        'uses' => 'WelcomeController@storeHome',
        'as'   => 'home'
    ]);

    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', ['uses' => 'WelcomeController@storeDash', 'middleware' => 'auth.admin']);

        Route::get('{subs}', [
            'uses' => 'WelcomeController@storeDash',
            'middleware' => 'auth.admin'
        ])->where(['subs' => '.*']);
    });

    Route::group(['prefix' => 'templates'], function () {
        Route::get('admin', [
            'uses' => 'WelcomeController@storeDash',
            'as'   => 'dash',
            'middleware' => 'auth.admin'
        ]);

        //this route should probably no longer be used?
        Route::get('admin/system', ['uses' => 'WelcomeController@system', 'middleware' => 'auth.admin']);
    });

});

Route::get('test', 'WelcomeController@test');