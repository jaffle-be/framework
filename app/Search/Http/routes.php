<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'App\Search\Http',
    'as' => 'store.'
], function () {

    Route::group([
        'namespace' => 'Admin',
    ], function()
    {
        Route::group(['prefix' => 'templates/admin'], function () {
            //template files, load at top so we do not end up in the show method
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
        });
    });


    if(env('APP_MULTIPLE_LOCALES'))
    {
        foreach(config('system.locales') as $locale)
        {
            Route::resource("$locale/search", 'SearchController', ['only' => ['index']]);
        }
    }
    else{
        Route::resource('search', 'SearchController', ['only' => ['index']]);
    }

});