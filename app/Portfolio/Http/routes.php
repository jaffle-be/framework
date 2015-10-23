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
            Route::post('portfolio/batch-publish', 'PortfolioController@batchPublish');
            Route::post('portfolio/batch-unpublish', 'PortfolioController@batchUnpublish');
            Route::resource('portfolio/{portfolio}/collaboration', 'CollaborationController', ['only' => ['index', 'store']]);
        });
    });

    if(env('APP_MULTIPLE_LOCALES'))
    {
        foreach(config('system.locales') as $locale)
        {
            Route::get("$locale/portfolio", ['uses' => 'PortfolioController@index', 'as' => "$locale.portfolio.index"]);
            Route::get("$locale/portfolio/{project}", ['uses' => 'PortfolioController@show', 'as' => "$locale.portfolio.show"]);
        }
    }
    else{
        Route::get('portfolio', ['uses' => 'PortfolioController@index', 'as' => 'portfolio.index']);
        Route::get('portfolio/{project}', ['uses' => 'PortfolioController@show', 'as' => 'portfolio.show']);
    }

});