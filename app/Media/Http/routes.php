<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'App\Media\Http',
    'as'        => 'store.'
], function () {

    Route::group(['namespace' => 'Admin'], function () {
        Route::group(['prefix' => 'templates/admin/media'], function () {
            //template files, load at top so we do not end up in the show method
            Route::get('image/widget', 'ImageController@widget');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin/media'], function () {
            Route::resource('image', 'ImageController', ['only' => ['index', 'store', 'update', 'destroy']]);
            Route::post('image/sort', 'ImageController@sort');
        });
    });


});