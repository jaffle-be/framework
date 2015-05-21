<?php

/**
 * store controllers
 */
Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Blog\Http\Admin', 'prefix' => 'admin'], function () {
    Route::resource('blog', 'BlogController', ['as' => 'store', 'only' => ['index', 'show']]);
});

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Blog\Http'], function () {
    Route::resource('blog', 'BlogController', ['as' => 'store', 'only' => ['index', 'show']]);
});

/**
 * app controllers
 */
Route::group(['namespace' => 'App\Blog\Http\Admin', 'prefix' => 'admin'], function () {
    Route::resource('blog', 'BlogController', ['as' => 'app', 'only' => ['index', 'show']]);
});

Route::group(['namespace' => 'App\Blog\Http'], function () {

    Route::resource('blog', 'BlogController', ['as' => 'app', 'only' => ['index', 'show']]);
});