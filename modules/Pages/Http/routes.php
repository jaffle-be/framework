<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'Modules\Pages\Http\Admin',
    'as' => 'store.'
], function () {

    Route::group(['prefix' => 'templates/admin'], function () {
        //template files, load at top so we do not end up in the show method
        Route::get('pages/overview', 'PagesController@overview');
        Route::get('pages/detail', 'PagesController@detail');
    });

    //actual resource
    Route::group(['prefix' => 'api/admin'], function () {
        Route::resource('pages', 'PagesController');
        Route::post('pages/batch-delete', 'PagesController@batchDestroy');
        Route::post('pages/link-subpage', 'PagesController@linkSubpage');
        Route::post('pages/unlink-subpage', 'PagesController@unlinkSubpage');
        Route::post('pages/sort-subpages', 'PagesController@sortSubpages');
        Route::post('pages/batch-publish', 'PagesController@batchPublish');
        Route::post('pages/batch-unpublish', 'PagesController@batchUnpublish');
    });
});

Route::group(['namespace' => 'Modules\Pages\Http'], function () {

});