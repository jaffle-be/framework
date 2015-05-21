<?php

/**
 * ATTENTION
 *
 * YOU NEED TO PLACE ALL SUBDOMAIN ROUTES FIRST
 * THEN ALL ROUTES FOR THE APP ITSELF
 */
Route::group(['domain' => config('app.subdomain')], function(){
    Route::get('/', [
        'uses' => 'WelcomeController@storeHome',
        'as' => 'home'
    ]);

    Route::get('admin', [
        'uses' => 'WelcomeController@start',
        'as' => 'start'
    ]);
});

Route::get('/', 'WelcomeController@appHome');


Route::get('test', 'WelcomeController@test');
Route::get('test2', 'WelcomeController@test2');