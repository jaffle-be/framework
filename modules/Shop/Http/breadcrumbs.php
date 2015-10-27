<?php

if(env('APP_MULTIPLE_LOCALES'))
{
    foreach(config('system.locales') as $locale)
    {

        Breadcrumbs::register("store.$locale.shop.index", function($breadcrumbs) use ($locale)
        {
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push(Lang::get('shop::front.shop'), store_route('store.shop.index'));
        });

        Breadcrumbs::register("store.$locale.shop.checkout.index", function($breadcrumbs) use ($locale)
        {
            $breadcrumbs->parent("store.$locale.shop.index");
            $breadcrumbs->push(Lang::get('shop::front.checkout'), store_route('store.shop.checkout.index'));
        });

        Breadcrumbs::register("store.$locale.shop.login", function($breadcrumbs) use ($locale)
        {
            $breadcrumbs->parent("store.$locale.shop.index");
            $breadcrumbs->push(Lang::get('shop::front.login'), store_route('store.shop.login'));
        });

        Breadcrumbs::register("store.$locale.shop.show", function($breadcrumbs) use ($locale)
        {
            $breadcrumbs->parent("store.$locale.shop.index");
            $breadcrumbs->push(Lang::get('shop::front.show'), store_route('store.shop.show'));
        });

        Breadcrumbs::register("store.$locale.shop.product", function($breadcrumbs, $product) use ($locale)
        {
            $breadcrumbs->parent("store.$locale.shop.show");
            $breadcrumbs->push(Lang::get('shop::front.product'), store_route('store.shop.product', [$product]));
        });

        Breadcrumbs::register("store.$locale.shop.register", function($breadcrumbs) use ($locale)
        {
            $breadcrumbs->parent("store.$locale.shop.index");
            $breadcrumbs->push(Lang::get('shop::front.register'), store_route('store.shop.register'));
        });
    }
}

else{

    Breadcrumbs::register('store.shop.index', function($breadcrumbs)
    {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push(Lang::get('shop::front.shop'), store_route('store.shop.index'));
    });

    Breadcrumbs::register('store.shop.checkout.index', function($breadcrumbs)
    {
        $breadcrumbs->parent('store.shop.index');
        $breadcrumbs->push(Lang::get('shop::front.checkout'), store_route('store.shop.checkout.index'));
    });

    Breadcrumbs::register('store.shop.login', function($breadcrumbs)
    {
        $breadcrumbs->parent('store.shop.index');
        $breadcrumbs->push(Lang::get('shop::front.login'), store_route('store.shop.login'));
    });

    Breadcrumbs::register('store.shop.show', function($breadcrumbs)
    {
        $breadcrumbs->parent('store.shop.index');
        $breadcrumbs->push(Lang::get('shop::front.show'), store_route('store.shop.show'));
    });

    Breadcrumbs::register('store.shop.product', function($breadcrumbs, $product)
    {
        $breadcrumbs->parent('store.shop.show');
        $breadcrumbs->push(Lang::get('shop::front.product'), store_route('store.shop.product', [$product]));
    });

    Breadcrumbs::register('store.shop.register', function($breadcrumbs)
    {
        $breadcrumbs->parent('store.shop.index');
        $breadcrumbs->push(Lang::get('shop::front.register'), store_route('store.shop.register'));
    });

}