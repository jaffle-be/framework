<?php

Breadcrumbs::register('store.blog.index', function($breadcrumbs){

    $breadcrumbs->parent('store.home');
    $breadcrumbs->push('News' , route('store.blog.index'));

});