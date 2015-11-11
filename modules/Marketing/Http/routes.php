<?php

/**
 * store controllers
 */
Route::group([
    'namespace' => 'Modules\Marketing\Http',
    'as' => 'store.'
], function () {

    Route::group([
        'namespace' => 'Admin',
    ], function()
    {
        Route::group(['prefix' => 'templates/admin'], function () {
            //template files, load at top so we do not end up in the show method
            Route::get('marketing/overview', 'MarketingController@overview');

            Route::get('marketing/newsletter/overview', 'NewsletterCampaignController@overview');
            Route::get('marketing/newsletter/detail', 'NewsletterCampaignController@detail');

            Route::get('marketing/newsletter/subscriptions', 'NewsletterSubscriptionController@subscriptions');
        });

        //actual resource
        Route::group(['prefix' => 'api/admin'], function () {

            Route::post('marketing/newsletter/batch-delete', 'NewsletterCampaignController@batchDestroy');
            Route::get('marketing/newsletter/subscriptions', 'NewsletterSubscriptionController@index');
            Route::get('marketing/newsletter/search', 'NewsletterCampaignController@search');

            Route::resource('marketing/newsletter/campaign', 'NewsletterCampaignController');
            Route::post('marketing/newsletter/campaign/{campaign}/prepare', 'NewsletterCampaignController@prepare');
            Route::post('marketing/newsletter/campaign/{campaign}/send', 'NewsletterCampaignController@send');

            Route::resource('marketing/newsletter/campaign/{campaign}/campaign-widget', 'NewsletterWidgetController');
            Route::resource('marketing', 'MarketingController', ['only' => ['index', 'show', 'store', 'update']]);
        });
    });

    //FRONT ROUTES
    if(env('APP_MULTIPLE_LOCALES'))
    {
        foreach(config('system.locales') as $locale)
        {
            Route::post("$locale/newsletter", ['uses' => 'NewsletterSubscriptionController@store', 'as' => "$locale.newsletter.store"]);
            Route::get("$locale/newsletter", ['uses' => 'NewsletterSubscriptionController@index', 'as' => "$locale.newsletter.index"]);
        }
    }
    else{
        Route::post('newsletter', ['uses' => 'NewsletterSubscriptionController@store', 'as' => 'newsletter.store']);
    }

});