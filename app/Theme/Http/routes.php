<?php

/**
 * store controllers
 */
Route::group([
    'domain' => config('app.subdomain'),
    'namespace' => 'App\Theme\Http\Admin'
], function () {

    Route::group(['prefix' => 'templates/admin'], function () {
        //template files, load at top so we do not end up in the show method
        Route::get('theme/settings', 'ThemeController@settings');
    });

    //actual resource
    Route::group(['prefix' => 'api/admin'], function () {
        Route::resource('theme', 'ThemeController', ['as' => 'store', 'only' => ['index', 'show', 'store', 'update']]);
    });
});

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Theme\Http'], function () {
//    Route::resource('theme', 'ThemeController', ['as' => 'store', 'only' => ['index', 'show']]);
});