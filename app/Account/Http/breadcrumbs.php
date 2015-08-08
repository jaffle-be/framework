<?php

Breadcrumbs::register('store.team.index', function($breadcrumbs){

    $breadcrumbs->parent('store.home');
    $breadcrumbs->push('About', route('store.team.index'));

});

Breadcrumbs::register('store.team.show', function($breadcrumbs, $member){

    $breadcrumbs->parent('store.team.index');
    $breadcrumbs->push($member->name, route('store.team.show'));

});