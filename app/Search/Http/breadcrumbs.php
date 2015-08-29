<?php

Breadcrumbs::register('store.search.index', function($breadcrumbs){

    $breadcrumbs->parent('store.home');
    $breadcrumbs->push('Find' , route('store.search.index'));

});