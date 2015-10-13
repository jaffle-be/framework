<?php

Breadcrumbs::register('store.portfolio.index', function($breadcrumbs){
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push('Projects', route('store.portfolio.index'));
});


Breadcrumbs::register('store.portfolio.show', function($breadcrumbs){
    $breadcrumbs->parent('store.portfolio.index');
    $breadcrumbs->push('Project', route('store.portfolio.index'));
});