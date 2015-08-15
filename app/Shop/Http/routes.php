<?php

Route::group([
    'namespace' => 'App\Shop\Http',
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
});