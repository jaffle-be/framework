<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'Modules\Blog\Http',
    'as'        => 'store.',
    'middleware' => ['web'],
], function () {

    Route::group([
        'namespace' => 'Admin',
    ], function () {
        Route::group(['prefix' => 'templates/admin'], function () {
            //template files, load at top so we do not end up in the show method
            Route::get('blog/overview', 'BlogController@overview');
            Route::get('blog/detail', 'BlogController@detail');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
            Route::resource('blog', 'BlogController');
            Route::post('blog/batch-delete', 'BlogController@batchDestroy');
            Route::post('blog/batch-publish', 'BlogController@batchPublish');
            Route::post('blog/batch-unpublish', 'BlogController@batchUnpublish');
        });
    });

    //FRONT ROUTES
    if (env('APP_MULTIPLE_LOCALES')) {
        foreach (config('system.locales') as $locale) {
            Route::get("$locale/blog", ['uses' => 'BlogController@index', 'as' => "$locale.blog.index"]);
        }
    } else {
        Route::get('blog', ['uses' => 'BlogController@index', 'as' => 'blog.index']);
    }
});