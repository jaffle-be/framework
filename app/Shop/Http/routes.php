<?php

Route::group(['namespace' => 'App\Shop\Http'], function () {

    //login pages
    Route::get('shop/register', 'AuthController@register');
    Route::get('shop/login', 'AuthController@login');

    //checkout pages
    Route::resource('shop/checkout', 'CheckoutController', ['only' => ['index', 'post']]);

    //the shop product page
    Route::get('shop/product/{product}', 'ShopController@product');

    //the shop homepage and the shop category page - KEEP AT BOTTOM
    Route::resource('shop', 'ShopController', ['only' => ['index', 'show']]);


});