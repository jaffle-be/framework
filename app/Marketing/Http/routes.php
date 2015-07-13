<?php

/**
 * store controllers
 */
Route::group([
    'domain' => config('app.subdomain'),
    'namespace' => 'App\Marketing\Http\Admin'
], function () {

    Route::group(['prefix' => 'templates/admin'], function () {
        //template files, load at top so we do not end up in the show method
        Route::get('marketing/overview', 'MarketingController@overview');
//        Route::get('marketing/detail', 'MarketingController@detail');
    });

    //actual resource
    Route::group(['prefix' => 'api/admin'], function () {
        Route::resource('marketing', 'MarketingController', ['as' => 'store', 'only' => ['index', 'show', 'store', 'update']]);
    });
});

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Marketing\Http'], function () {
//    Route::resource('marketing', 'MarketingController', ['as' => 'store', 'only' => ['index', 'show']]);
});