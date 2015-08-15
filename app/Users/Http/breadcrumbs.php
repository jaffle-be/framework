<?php

//SIGNIN - SIGNOUT

Breadcrumbs::register('store.auth.signin.index', function($breadcrumbs)
{
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push(Lang::get('users::front.signin'), route('store.auth.signin.index'));
});


Breadcrumbs::register('store.auth.signout.index', function($breadcrumbs)
{
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push(Lang::get('users::front.signout'), route('store.auth.signout.index'));
});

// SIGNUP

Breadcrumbs::register('store.auth.signup.index', function($breadcrumbs)
{
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push(Lang::get('users::front.signup'), route('store.auth.signup.index'));
});

Breadcrumbs::register('store.auth.confirm-email.create', function($breadcrumbs)
{
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push(Lang::get('users::front.confirm-email'), route('store.auth.confirm-email.create'));
});

Breadcrumbs::register('store.auth.confirm-email.show', function($breadcrumbs)
{
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push(Lang::get('users::front.confirm-email'), route('store.auth.confirm-email.show'));
});


//FORGOT PASSWORD

Breadcrumbs::register('store.auth.forgot-password.index', function($breadcrumbs)
{
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push(Lang::get('users::front.forgot-password'), route('store.auth.forgot-password.index'));
});

Breadcrumbs::register('store.auth.reset-password.show', function($breadcrumbs)
{
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push(Lang::get('users::front.reset-password'), route('store.auth.reset-password.show'));
});


//INVITATION

Breadcrumbs::register('store.auth.invitation.show', function($breadcrumbs)
{
    $breadcrumbs->parent('store.home');
    $breadcrumbs->push(Lang::get('users::front.invitation'), route('store.auth.invitation.show'));
});

