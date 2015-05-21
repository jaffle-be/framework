<?php

Route::group(['namespace' => 'App\Blog\Http'], function () {

    Route::resource('blog', 'BlogController', ['only' => ['index', 'show']]);
});

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Blog\Http\Admin', 'prefix' => 'admin'], function () {

    Route::resource('blog', 'BlogController', ['only' => ['index', 'show']]);
});