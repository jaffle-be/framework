<?php

Route::group([
    'as' => 'store.'
], function () {


    Route::group(['namespace' => 'App\Account\Http\Admin'], function()
    {
        Route::group(['prefix' => 'templates/admin/account'], function () {
            //template files, load at top so we do not end up in the show method
            Route::get('contact/page', 'ContactController@page');
            Route::get('members/page', 'MembershipController@page');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin/account'], function () {
            Route::resource('account-contact-information', 'ContactController', ['only' => ['index', 'store', 'update']]);
            Route::resource('members', 'MembershipController', ['only' => ['index', 'update', 'destroy']]);
            Route::resource('members/invitation', 'MembershipInvitationController', ['only' => ['index', 'store', 'destroy']]);
        });
    });

    Route::group(['namespace' => 'App\Account\Http'], function()
    {
        Route::resource('auth/invitation', 'MembershipInvitationController', ['only' => ['show', 'update']]);
    });

});
