<?php

use App\Blog\PostTranslation;
use App\Pages\PageTranslation;

Breadcrumbs::register('store.uri.show', function($breadcrumbs, $uri, $suburi = null, $subesturi= null){

    if($uri->owner instanceof PostTranslation)
    {
        $breadcrumbs->parent('store.blog.index');
        $breadcrumbs->push('Post');
    }
    elseif($uri->owner instanceof PageTranslation)
    {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('Page');
    }

});