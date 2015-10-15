<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'App\Pages\Http\Admin',
    'as' => 'store.'
], function () {

    Route::group(['prefix' => 'templates/admin'], function () {
        //template files, load at top so we do not end up in the show method
        Route::get('pages/overview', 'PagesController@overview');
        Route::get('pages/detail', 'PagesController@detail');
    });

    //actual resource
    Route::group(['prefix' => 'api/admin'], function () {
        Route::resource('pages', 'PagesController');
        Route::post('pages/batch-delete', 'PagesController@batchDestroy');
    });
});

Route::group(['namespace' => 'App\Pages\Http'], function () {
//    Route::resource('pages', 'PagesController', ['as' => 'store', 'only' => ['index', 'show']]);
});