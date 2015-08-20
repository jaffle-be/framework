<?php

// Home > Contact
Breadcrumbs::register('store.contact.index', function($breadcrumbs)
{
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push(Lang::get('contact::front.breadcrumb'), route('store.contact.index'));
});
