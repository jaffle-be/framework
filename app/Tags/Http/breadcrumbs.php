<?php

Breadcrumbs::register('store.tags.show', function($breadcrumbs){
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push('Tag', 'store.blog.show');
});