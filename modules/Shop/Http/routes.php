<?php

Route::group([
    'namespace' => 'Modules\Shop\Http',
    'as' => 'store.',
    'middleware' => ['web'],
], function () {

    //admin routes
    Route::group([
        'namespace' => 'Admin',
    ], function () {
        Route::group(['prefix' => 'templates/admin'], function () {
            Route::get('notifications', 'NotificationController@template');
            Route::get('categories/overview', 'GammaController@templateCategories');
            Route::get('brands/overview', 'GammaController@templateBrands');
            Route::get('products/overview', 'ProductController@overview');
            Route::get('products/detail', 'ProductController@detail');
            Route::get('shop/gamma/selections/overview', 'ProductSelectionController@overview');
            Route::get('shop/gamma/selections/detail', 'ProductSelectionController@detail');
        });

        Route::group(['prefix' => 'api/admin/shop'], function () {

            Route::resource('properties/values', 'PropertyValueController', ['only' => ['store', 'update', 'destroy']]);
            Route::resource('properties/options', 'PropertyOptionController', ['only' => ['store', 'update', 'destroy']]);
            Route::resource('properties/units', 'PropertyUnitController', ['only' => ['store', 'update', 'destroy']]);

            Route::post('properties/groups/sort', 'PropertyGroupController@sortGroups');
            Route::resource('properties/groups', 'PropertyGroupController', ['only' => ['store', 'update', 'destroy']]);

            Route::post('properties/sort', 'PropertyController@sortProperties');
            Route::post('properties/move', 'PropertyController@moveProperty');
            Route::resource('properties', 'PropertyController', ['only' => ['store', 'update', 'destroy']]);

            Route::post('products/suggest', 'ProductController@suggest');
            Route::post('products/add-category', 'ProductController@addCategory');
            Route::post('products/remove-category', 'ProductController@removeCategory');
            Route::post('gamma/selections/suggest', 'ProductController@suggest');
            Route::post('categories/suggest', 'CategoryController@suggest');
            Route::post('brands/suggest', 'BrandController@suggest');

            Route::resource('categories', 'CategoryController');

            Route::get('gamma/notifications', 'NotificationController@overview');
            Route::post('gamma/notifications/accept', 'NotificationController@accept');
            Route::post('gamma/notifications/review', 'NotificationController@review');
            Route::post('gamma/notifications/deny', 'NotificationController@deny');

            Route::get('gamma/categories', 'GammaController@categories');
            Route::post('gamma/categories', 'GammaController@category');
            Route::get('gamma/brands', 'GammaController@brands');
            Route::post('gamma/brands', 'GammaController@brand');
            Route::post('gamma/detail', 'GammaController@detail');

            Route::resource('gamma/selections', 'ProductSelectionController', ['only' => ['index', 'show', 'update']]);
            Route::post('gamma/selections/batch-publish', 'ProductSelectionController@batchPublish');
            Route::post('gamma/selections/batch-unpublish', 'ProductSelectionController@batchUnpublish');

            Route::resource('products', 'ProductController');
            Route::post('products/batch-delete', 'ProductController@batchDestroy');
            Route::post('products/batch-publish', 'ProductController@batchPublish');
            Route::post('products/batch-unpublish', 'ProductController@batchUnpublish');
        });
    });

    if (env('APP_MULTIPLE_LOCALES')) {
        foreach (config('system.locales') as $locale) {
            //front routes

            //login pages
            Route::get("$locale/shop/register", ['uses' => 'AuthController@register', 'as' => "$locale.shop.register"]);
            Route::get("$locale/shop/login", ['uses' => 'AuthController@login', 'as' => "$locale.shop.login"]);

            //checkout pages
            Route::resource("$locale/shop/checkout", 'CheckoutController', ['only' => ['index', 'post']]);

            //these routes can be improved by the uri system.
            //route for products per brand -> this route should be optional.. a customer will mostly look using category

            //route for product per category
            Route::get("$locale/shop/category/{category}/{brand?}", ['uses' => 'ShopController@category', 'as' => "$locale.shop.category"]);
            //the shop product page
            Route::get("$locale/shop/product/{product}", ['uses' => 'ShopController@product', 'as' => "$locale.shop.product"]);

            //route for products

            //the shop homepage and the shop category page - KEEP AT BOTTOM
            Route::resource("$locale/shop", 'ShopController', ['only' => ['index']]);
        }
    } else {
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
