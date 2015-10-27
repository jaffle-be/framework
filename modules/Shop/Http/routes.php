<?php

Route::group([
    'namespace' => 'Modules\Shop\Http',
    'as' => 'store.',
], function () {

    //admin routes
    Route::group([
        'namespace' => 'Admin',
    ], function () {
        Route::group(['prefix' => 'templates/admin'], function () {
            Route::resource('products', 'ProductController', ['only' => 'index']);
        });

        Route::group(['prefix' => 'admin'], function () {
            Route::resource('products', 'ProductController', ['only' => 'index']);
        });
    });





    if(env('APP_MULTIPLE_LOCALES'))
    {
        foreach (config('system.locales') as $locale) {
            //front routes

            //login pages
            Route::get("$locale/shop/register", ['uses' => 'AuthController@register', 'as' => "$locale.shop.register"]);
            Route::get("$locale/shop/login", ['uses' => 'AuthController@login', 'as' => "$locale.shop.login"]);

            //checkout pages
            Route::resource("$locale/shop/checkout", 'CheckoutController', ['only' => ['index', 'post']]);

            //the shop product page
            Route::get("$locale/shop/product/{product}", ['uses' => 'ShopController@product', 'as' => "$locale.shop.product"]);

            //the shop homepage and the shop category page - KEEP AT BOTTOM
            Route::resource("$locale/shop", 'ShopController', ['only' => ['index', 'show']]);
        }
    }
    else{
        //front routes

        //login pages
        Route::get('shop/register', ['uses' => 'AuthController@register', 'as' => 'shop.register']);
        Route::get('shop/login', ['uses' => 'AuthController@login', 'as' => 'shop.login']);

        //checkout pages
        Route::resource('shop/checkout', 'CheckoutController', ['only' => ['index', 'post']]);

        //the shop product page
        Route::get('shop/product/{product}', ['uses' => 'ShopController@product', 'as' => 'shop.product']);

        //the shop homepage and the shop category page - KEEP AT BOTTOM
        Route::resource('shop', 'ShopController', ['only' => ['index', 'show']]);
    }
});