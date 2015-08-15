<?php

Route::group([
    'namespace' => 'App\System\Http',
    'as' => 'store.',
], function () {

    Route::group([
        'namespace' => 'admin',
    ], function()
    {
        Route::group(['prefix' => 'templates/admin'], function () {

        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
            Route::resource('system', 'SystemController', ['only' => ['index']]);
        });
    });

});