<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'App\Theme\Http',
    'as' => 'store.',
], function () {

    Route::group([
        'namespace' => 'admin'
    ], function () {
        Route::group(['prefix' => 'templates/admin'], function () {
            //template files, load at top so we do not end up in the show method
            Route::get('theme/settings', 'ThemeController@settings');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
            Route::resource('theme', 'ThemeController', ['only' => ['index', 'show', 'store', 'update']]);
        });
    });
});