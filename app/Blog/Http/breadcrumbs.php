<?php

use App\Blog\Post;

Breadcrumbs::register('store.blog.index', function($breadcrumbs){

    $breadcrumbs->parent('store.home');
    $breadcrumbs->push('News' , route('store.blog.index'));

});

Breadcrumbs::register('store.blog.show', function($breadcrumbs, Post $post){
    $breadcrumbs->parent('store.blog.index');
    $breadcrumbs->push($post->title, 'store.blog.show');
});