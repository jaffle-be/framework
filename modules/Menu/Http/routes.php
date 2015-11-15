<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'Modules\Menu\Http',
    'as'        => 'store.'
], function () {

    Route::group(['namespace' => 'Admin'], function () {
        Route::group(['prefix' => 'templates/admin'], function () {
            //template files, load at top so we do not end up in the show method
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
            Route::resource('menu', 'MenuController', ['only' => ['index', 'store', 'update', 'destroy']]);
            Route::post('menu/{menu}/sort', 'MenuController@sort');
            Route::resource('menu/{menu}/menu-item', 'MenuItemController', ['only' => ['store', 'update', 'destroy']]);
        });
    });
});