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
            Route::get('video/widget', 'VideoController@widget');
            Route::get('infographic/widget', 'InfographicController@widget');
            Route::get('file/widget', 'FileController@widget');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin/media'], function () {
            Route::resource('image', 'ImageController', ['only' => ['index', 'store', 'update', 'destroy']]);
            Route::post('image/sort', 'ImageController@sort');

            Route::resource('video', 'VideoController', ['only' => ['index', 'store', 'update', 'destroy']]);
            Route::post('video/sort', 'VideoController@sort');
            Route::get('video/search', 'VideoController@search');

            Route::resource('infographic', 'InfographicController', ['only' => ['index', 'store', 'update', 'destroy']]);
            Route::post('infographic/sort', 'InfographicController@sort');

            Route::resource('file', 'FileController', ['only' => ['index', 'store', 'update', 'destroy']]);
            Route::post('file/sort', 'FileController@sort');
        });
    });
});