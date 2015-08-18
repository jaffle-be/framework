<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'App\Search\Http',
    'as' => 'store.'
], function () {

    Route::group([
        'namespace' => 'Admin',
    ], function()
    {
        Route::group(['prefix' => 'templates/admin'], function () {
            //template files, load at top so we do not end up in the show method
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
        });
    });


    Route::resource('search', 'SearchController', ['only' => ['index']]);
});