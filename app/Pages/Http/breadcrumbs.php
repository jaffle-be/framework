<?php
Breadcrumbs::register('store.pages.show', function($breadcrumbs, $page)
{
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push('Page', route('store.pages.show'));
});
