<?php

Route::group(['domain' => config('app.subdomain'), 'namespace' => 'App\Layout\Http', 'prefix' => 'admin'], function () {

    //thes routes will load the template files for each angular ui-section in the admin
    Route::resource('templates', 'TemplateController', ['only' => ['show']]);
});
