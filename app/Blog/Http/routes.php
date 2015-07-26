<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'App\Blog\Http',
    'as' => 'store.'
], function () {

    Route::group([
        'namespace' => 'Admin',
    ], function()
    {
        Route::group(['prefix' => 'templates/admin'], function () {
            //template files, load at top so we do not end up in the show method
            Route::get('blog/overview', 'BlogController@overview');
            Route::get('blog/detail', 'BlogController@detail');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
            Route::resource('blog', 'BlogController', ['only' => ['index', 'show', 'store', 'update']]);
            Route::resource('blog/{blog}/image', 'BlogImageController', ['only' => ['store', 'destroy', 'update']]);
            Route::resource('blog/{blog}/tag', 'BlogTagController', ['only' => ['index', 'store', 'destroy', 'update']]);
        });
    });


    Route::resource('blog', 'BlogController', ['only' => ['index', 'show']]);
});