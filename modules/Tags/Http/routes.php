<?php

/**
 * store controllers.
 */
Route::group([
    'namespace' => 'Modules\Tags\Http',
    'as' => 'store.',
    'middleware' => ['web'],
], function () {

    Route::group(['namespace' => 'Admin'], function () {
        Route::group(['prefix' => 'templates/admin'], function () {
            //template files, load at top so we do not end up in the show method
            Route::get('tag/widget', 'TagController@widget');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
            Route::resource('tag', 'TagController', ['only' => ['index', 'store', 'update', 'destroy']]);
            Route::get('tag/list', 'TagController@all');
        });
    });

    if (env('APP_MULTIPLE_LOCALES')) {
        foreach (config('system.locales') as $locale) {
            Route::resource("$locale/tags", 'TagsController', ['only' => ['show']]);
        }
    } else {
        Route::resource('tags', 'TagsController', ['only' => ['show']]);
    }
});
