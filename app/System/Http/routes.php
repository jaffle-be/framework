<?php

Route::group([
    'namespace' => 'App\System\Http',
    'as'        => 'store.',
], function () {

    Route::get('locale', ['uses' => 'SystemController@locale', 'as' => 'locale']);

    Route::group([
        'namespace' => 'Admin',
    ], function () {

        Route::post('pusher/auth', 'SystemController@pusher');

        Route::group(['prefix' => 'templates/admin'], function () {
            //template files, load at top so we do not end up in the show method
            Route::get('seo/widget', 'SeoController@widget');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
            Route::resource('system', 'SystemController', ['only' => ['index']]);
            Route::post('system/locale', 'SystemController@locale');
            Route::resource('seo', 'SeoController', ['only' => ['index', 'store']]);
        });
    });
});