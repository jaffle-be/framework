<?php

// Home
Breadcrumbs::register('store.home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('store.home'));
});