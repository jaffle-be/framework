<?php
//both admins use the same controllers to load the appropriate templates
//Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Layout\Http', 'prefix' => 'admin'], function () {
//    Route::resource('templates', 'TemplateController', ['only' => ['show']]);
//});

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Layout\Http', 'prefix' => 'templates'], function() {
    Route::get('admin/layout/{template}', 'TemplateController@template');
});


Route::group(['namespace' => 'App\Layout\Http', 'prefix' => 'admin'], function () {
    //these routes will load the template files for each angular ui-section in the admin
    Route::resource('templates', 'TemplateController', ['only' => ['show']]);
});
