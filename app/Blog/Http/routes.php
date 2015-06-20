<?php

/**
 * store controllers
 */
Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Blog\Http\Admin'], function () {

    Route::group(['prefix' => 'templates/admin'], function () {
        //template files, load at top so we do not end up in the show method
        Route::get('blog/overview', 'BlogController@overview');
        Route::get('blog/detail', 'BlogController@detail');
    });

    //actual resource
    Route::group(['prefix' => 'api/admin'], function () {
        Route::resource('blog', 'BlogController', ['as' => 'store', 'only' => ['index', 'show', 'store', 'update']]);
        Route::resource('blog/{blog}/image', 'BlogImageController', [['as' => 'store'], 'only' => ['store', 'destroy', 'update']]);
        Route::resource('blog/{blog}/tag', 'BlogTagController', [['as' => 'store'], 'only' => ['index', 'store', 'destroy', 'update']]);
    });
});

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Blog\Http'], function () {
    Route::resource('blog', 'BlogController', ['as' => 'store', 'only' => ['index', 'show']]);
});

/**
 * app controllers
 */
Route::group(['namespace' => 'App\Blog\Http\Admin', 'prefix' => 'admin'], function () {
    Route::resource('blog', 'BlogController', ['as' => 'app', 'only' => ['index', 'edit', 'store', 'update']]);
});

Route::group(['namespace' => 'App\Blog\Http'], function () {
    Route::resource('blog', 'BlogController', ['as' => 'app', 'only' => ['index', 'show']]);
});