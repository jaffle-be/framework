<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'App\Tags\Http',
    'as'        => 'store.'
], function () {

    Route::group(['namespace' => 'Admin'], function () {
        Route::group(['prefix' => 'templates/admin'], function () {
        //template files, load at top so we do not end up in the show method
        Route::get('tag/widget', 'TagController@widget');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
            Route::resource('tag', 'TagController', ['only' => ['index', 'store', 'update', 'destroy']]);
            Route::get('tag/list', 'TagController@all');
        });
    });


});