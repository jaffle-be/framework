<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'App\Portfolio\Http',
    'as'        => 'store.'
], function () {

    Route::group(['namespace' => 'Admin'], function () {
        Route::group(['prefix' => 'templates/admin'], function () {
        //template files, load at top so we do not end up in the show method
        Route::get('portfolio/overview', 'PortfolioController@overview');
        Route::get('portfolio/detail', 'PortfolioController@detail');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {
            Route::resource('portfolio', 'PortfolioController');
            Route::post('portfolio/batch-delete', 'PortfolioController@batchDestroy');
            Route::resource('portfolio/{portfolio}/collaboration', 'CollaborationController', ['only' => ['index', 'store']]);
        });
    });


    Route::get('portfolio', ['uses' => 'PortfolioController@index', 'as' => 'portfolio.index']);
    Route::get('portfolio/{project}', ['uses' => 'PortfolioController@show', 'as' => 'portfolio.show']);

});