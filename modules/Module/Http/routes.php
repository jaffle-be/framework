<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'Modules\Module\Http',
    'as'        => 'store.'
], function () {

    Route::group([
        'namespace' => 'Admin',
    ], function () {
        Route::group(['prefix' => 'templates/admin'], function () {
            //template files, load at top so we do not end up in the show method
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
            Route::post('module/toggle', 'ModuleController@toggle');
        });
    });
});