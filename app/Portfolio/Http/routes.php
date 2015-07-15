<?php

/**
 * store controllers
 */
Route::group([
    'domain' => config('app.subdomain'),
    'namespace' => 'App\Portfolio\Http\Admin'
], function () {

    Route::group(['prefix' => 'templates/admin'], function () {
        //template files, load at top so we do not end up in the show method
//        Route::get('portfolio/overview', 'PortfolioController@overview');
//        Route::get('portfolio/detail', 'PortfolioController@detail');
    });

    //actual resource
    Route::group(['prefix' => 'api/admin'], function () {
        Route::resource('portfolio', 'PortfolioController', ['as' => 'store', 'only' => ['index', 'show', 'store', 'update']]);
    });
});

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Portfolio\Http'], function () {
//    Route::resource('portfolio', 'PortfolioController', ['as' => 'store', 'only' => ['index', 'show']]);
});