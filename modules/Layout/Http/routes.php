<?php

Route::group([
    'namespace' => 'Modules\Layout\Http',
    'as'        => 'store.',
    'middleware' => ['web'],
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