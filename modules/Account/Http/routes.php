<?php

Route::group([
    'as' => 'store.',
    'middleware' => ['web'],
], function () {

    Route::group(['namespace' => 'Modules\Account\Http\Admin'], function () {
        Route::group(['prefix' => 'templates/admin/account'], function () {
            //template files, load at top so we do not end up in the show method
            Route::get('contact/page', 'ContactController@page');
            Route::get('members/page', 'MembershipController@page');
            Route::get('clients/page', 'ClientController@page');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin/account'], function () {
            Route::resource('account-contact-information', 'ContactController', ['only' => ['index', 'store', 'update']]);
            Route::resource('team', 'TeamController', ['only' => ['index', 'store', 'destroy', 'update']]);
            Route::resource('client', 'ClientController', ['only' => ['index', 'store', 'destroy', 'update']]);
            Route::post('team/{team}/toggle-membership', 'TeamController@toggleMembership');
            Route::resource('members/membership', 'MembershipController', ['only' => ['index', 'update', 'destroy']]);
            Route::resource('members/invitation', 'MembershipInvitationController', ['only' => ['index', 'store', 'destroy']]);
        });
    });

    Route::group(['namespace' => 'Modules\Account\Http'], function () {
        Route::resource('auth/invitation', 'MembershipInvitationController', ['only' => ['show', 'update']]);

        if (env('APP_MULTIPLE_LOCALES')) {
            foreach (config('system.locales') as $locale) {
                Route::resource("$locale/team", 'TeamController', ['only' => ['index', 'show']]);
            }
        } else {
            Route::resource('team', 'TeamController', ['only' => ['index', 'show']]);
        }
    });
});
