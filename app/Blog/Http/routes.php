<?php

Route::group(['namespace' => 'App\Blog\Http'], function () {

    Route::resource('blog', 'BlogController', ['only' => ['index', 'show']]);
});