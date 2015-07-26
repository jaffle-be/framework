<?php
//both admins use the same controllers to load the appropriate templates
//Route::group(['domain' => route_subdomain(), 'namespace' => 'App\Layout\Http', 'prefix' => 'admin'], function () {
//    Route::resource('templates', 'TemplateController', ['only' => ['show']]);
//});

Route::group([
    'namespace' => 'App\Layout\Http',
    'as'        => 'store.'
],
    function () {

        Route::group(['prefix' => 'admin'], function () {
            //these routes will load the template files for each angular ui-section in the admin
            Route::resource('templates', 'TemplateController', ['only' => ['show']]);
        });

        Route::group(['prefix' => 'templates'], function () {
            Route::get('admin/layout/{template}', 'TemplateController@template');
        });
    });