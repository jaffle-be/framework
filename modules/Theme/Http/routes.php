<?php

/**
 * store controllers.
 */
Route::group([
    'namespace' => 'Modules\Theme\Http',
    'as' => 'store.',
    'middleware' => ['web'],
], function () {

    Route::group([
        'namespace' => 'Admin',
    ], function () {
        Route::group(['prefix' => 'templates/admin'], function () {
            //template files, load at top so we do not end up in the show method
            Route::get('theme/settings', 'ThemeController@settings');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
            Route::resource('theme', 'ThemeController', ['only' => ['index']]);
            Route::get('theme/current', 'ThemeController@current');
            Route::post('theme/{theme}/activate', 'ThemeController@activate');
            Route::post('theme/{theme}/setting/{setting}', 'ThemeController@setting');
        });
    });
});
