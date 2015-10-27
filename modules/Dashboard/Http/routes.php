<?php

/**
 * templates stores
 */
Route::group([
    'namespace' => 'Modules\Dashboard\Http',
    'as' => 'store.',
], function () {

    if(env('APP_MULTIPLE_LOCALES'))
    {
        foreach (config('system.locales') as $locale) {
            Route::get("/$locale", [
                'uses' => 'WelcomeController@storeHome',
                'as'   => "$locale.home"
            ]);
        }
    }
    else{
        Route::get('/', [
            'uses' => 'WelcomeController@storeHome',
            'as'   => 'home'
        ]);
    }

    Route::group(['prefix' => 'templates'], function()
    {
        Route::resource('admin/start', 'Admin\DashboardController', ['only' => ['index']]);
    });

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

//Route::get('test', 'WelcomeController@test');