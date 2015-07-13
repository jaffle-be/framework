<?php

/**
 * store controllers
 */
Route::group([
    'domain' => config('app.subdomain'),
    'namespace' => 'App\System\Http\Admin'
], function () {

    Route::group(['prefix' => 'templates/admin'], function () {
        //template files, load at top so we do not end up in the show method
//        Route::get('system/overview', 'SystemController@overview');
//        Route::get('system/detail', 'SystemController@detail');
    });

    //actual resource
    Route::group(['prefix' => 'api/admin'], function () {
        Route::resource('system', 'SystemController', ['as' => 'store', 'only' => ['index']]);
    });
});

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\System\Http'], function () {
//    Route::resource('system', 'SystemController', ['as' => 'store', 'only' => ['index', 'show']]);
});