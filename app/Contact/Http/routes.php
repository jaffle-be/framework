<?php

Route::group([
    'namespace' => 'App\Contact\Http',
    'as' => 'store.'
], function () {

    Route::group(['namespace' => 'Admin'], function()
    {
        Route::group(['prefix' => 'api/admin'], function()
        {
            Route::resource('contact/address', 'ContactAddressController', ['only' => ['show', 'store', 'update']]);
            Route::resource('contact/social-links', 'SocialLinksController', ['only' => ['index', 'show', 'store', 'update']]);
        });

        Route::group(['prefix' => 'templates/admin/contact'], function () {
            //template files, load at top so we do not end up in the show method
            Route::get('address/widget', 'ContactAddressController@widget');
            Route::get('social-links/widget', 'SocialLinksController@widget');
        });
    });


    if(env('APP_MULTIPLE_LOCALES'))
    {
        foreach(config('system.locales') as $locale)
        {
            Route::resource("$locale/contact", 'ContactController', ['only' => ['index', 'store']]);
        }
    }
    else{
        Route::resource('contact', 'ContactController', ['only' => ['index', 'store']]);
    }


});