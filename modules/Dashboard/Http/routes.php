<?php

/**
 * templates stores
 */
Route::group([
    'namespace' => 'Modules\Dashboard\Http',
    'as'        => 'store.',
    'middleware' => ['web'],
], function () {

    /**
     * this is a special case:
     *
     * when installing as a multi locale application
     * we want our root page to be a locale selector page.
     *
     * if not, it should be the home page itself. therefor, we have one extra route
     * when installing as a multi locale app.
     */

    if (env('APP_MULTIPLE_LOCALES')) {
        foreach (config('system.locales') as $locale) {
            Route::get("/$locale", [
                'uses' => 'WelcomeController@storeHome',
                'as'   => "$locale.home"
            ]);
        }

        Route::get('/', ['uses' => 'WelcomeController@landing', 'as' => 'landing']);
    } else {
        Route::get('/', [
            'uses' => 'WelcomeController@storeHome',
            'as'   => 'home'
        ]);
    }

    Route::group(['prefix' => 'templates'], function () {
        Route::resource('admin/start', 'Admin\DashboardController', ['only' => ['index']]);
    });

    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', ['uses' => 'WelcomeController@storeDash', 'middleware' => 'auth.admin']);

        Route::get('{subs}', [
            'uses'       => 'WelcomeController@storeDash',
            'middleware' => 'auth.admin'
        ])->where(['subs' => '.*']);
    });

    Route::group(['prefix' => 'templates'], function () {
        Route::get('admin', [
            'uses'       => 'WelcomeController@storeDash',
            'as'         => 'dash',
            'middleware' => 'auth.admin'
        ]);

        //this route should probably no longer be used?
        Route::get('admin/system', ['uses' => 'WelcomeController@system', 'middleware' => 'auth.admin']);
    });
});

//Route::get('test', 'WelcomeController@test');