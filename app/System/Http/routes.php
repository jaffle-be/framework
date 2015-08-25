<?php

Route::group([
    'namespace' => 'App\System\Http',
    'as' => 'store.',
], function () {


    Route::get('locale', ['uses' => 'SystemController@locale', 'as' => 'locale']);

    Route::group([
        'namespace' => 'Admin',
    ], function()
    {
        Route::group(['prefix' => 'templates/admin'], function () {

        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
            Route::resource('system', 'SystemController', ['only' => ['index']]);
            Route::post('system/locale', 'SystemController@locale');
        });
    });
});