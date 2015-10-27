<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'Modules\Marketing\Http\Admin',
    'as' => 'store.',
], function () {

    Route::group(['prefix' => 'templates/admin'], function () {
        //template files, load at top so we do not end up in the show method
        Route::get('marketing/overview', 'MarketingController@overview');
//        Route::get('marketing/detail', 'MarketingController@detail');
    });

    //actual resource
    Route::group(['prefix' => 'api/admin'], function () {
        Route::resource('marketing', 'MarketingController', ['only' => ['index', 'show', 'store', 'update']]);
    });
});