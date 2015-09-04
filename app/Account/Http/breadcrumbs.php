<?php

use App\Users\User;

Breadcrumbs::register('store.team.index', function($breadcrumbs){

    $breadcrumbs->parent('store.home');
    $breadcrumbs->push('About', route('store.team.index'));

});

Breadcrumbs::register('store.team.show', function($breadcrumbs){

    $breadcrumbs->parent('store.team.index');
    $breadcrumbs->push('Member', route('store.team.show'));
});


Breadcrumbs::register('store.api.admin.account.members.invitation.store', function($breadcrumbs){

    $breadcrumbs->parent('store.home');
    $breadcrumbs->push(Lang::get('account::admin.users.invitation'));

});