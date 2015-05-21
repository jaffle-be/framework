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
        'as' => 'store.home'
    ]);

    Route::get('admin', [
        'uses' => 'WelcomeController@storeDash',
        'as' => 'store.dash'
    ]);
});

Route::get('/', ['uses' => 'WelcomeController@appHome', 'as' => 'app.home']);

Route::get('admin', [
    'uses' => 'WelcomeController@appDash',
    'as' => 'app.dash'
]);


Route::get('test', 'WelcomeController@test');
Route::get('test2', 'WelcomeController@test2');