<?php

use App\Users\User;

Breadcrumbs::register('store.team.index', function($breadcrumbs){

    $breadcrumbs->parent('store.home');
    $breadcrumbs->push('About', route('store.team.index'));

});

Breadcrumbs::register('store.team.show', function($breadcrumbs, $team){

    $member = User::find($team);

    $breadcrumbs->parent('store.team.index');
    $breadcrumbs->push($member->name, route('store.team.show'));

});