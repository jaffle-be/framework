<?php

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Account\Http\Admin', 'as' => 'store.'], function () {

    Route::group(['prefix' => 'templates/admin/account'], function () {
        //template files, load at top so we do not end up in the show method
        Route::get('contact/page', 'ContactController@page');
    });

    //actual resource
    Route::group(['prefix' => 'api/admin/account'], function () {
        Route::resource('contact', 'ContactController', ['only' => ['update']]);
    });
});
