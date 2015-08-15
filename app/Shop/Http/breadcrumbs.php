<?php

Breadcrumbs::register('store.shop.index', function($breadcrumbs)
{
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push(Lang::get('shop::front.shop'), route('store.shop.index'));
});

Breadcrumbs::register('store.shop.checkout.index', function($breadcrumbs)
{
    $breadcrumbs->parent('store.shop.index');
    $breadcrumbs->push(Lang::get('shop::front.checkout'), route('store.shop.checkout.index'));
});

Breadcrumbs::register('store.shop.login', function($breadcrumbs)
{
    $breadcrumbs->parent('store.shop.index');
    $breadcrumbs->push(Lang::get('shop::front.login'), route('store.shop.login'));
});

Breadcrumbs::register('store.shop.show', function($breadcrumbs)
{
    $breadcrumbs->parent('store.shop.index');
    $breadcrumbs->push(Lang::get('shop::front.show'), route('store.shop.show'));
});

Breadcrumbs::register('store.shop.product', function($breadcrumbs)
{
    $breadcrumbs->parent('store.shop.show');
    $breadcrumbs->push(Lang::get('shop::front.product'), route('store.shop.product'));
});

Breadcrumbs::register('store.shop.register', function($breadcrumbs)
{
    $breadcrumbs->parent('store.shop.index');
    $breadcrumbs->push(Lang::get('shop::front.register'), route('store.shop.register'));
});
