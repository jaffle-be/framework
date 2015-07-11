<?php

Route::group([
    'domain' => config('app.subdomain'),
    'namespace' => 'App\Contact\Http',
    'as' => 'store.'
], function () {

    Route::resource('contact', 'ContactController', ['only' => ['index', 'store']]);

    Route::group(['namespace' => 'Admin'], function()
    {
        Route::group(['prefix' => 'api/admin'], function()
        {
            Route::resource('contact/address', 'ContactAddressController', ['only' => ['show', 'store', 'update']]);
        });

        Route::group(['prefix' => 'templates/admin/contact'], function () {
            //template files, load at top so we do not end up in the show method
            Route::get('address/widget', 'ContactAddressController@widget');
        });
    });

});