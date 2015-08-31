<?php

use App\Blog\Post;

Breadcrumbs::register('store.blog.index', function($breadcrumbs){

    $breadcrumbs->parent('store.home');
    $breadcrumbs->push('News' , route('store.blog.index'));

});

Breadcrumbs::register('store.blog.show', function($breadcrumbs){
    $breadcrumbs->parent('store.blog.index');
    $breadcrumbs->push('Post', 'store.blog.show');
});