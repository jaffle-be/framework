<?php

if (env('APP_MULTIPLE_LOCALES')) {
    foreach (config('system.locales') as $locale) {
        //SIGNIN - SIGNOUT

        Breadcrumbs::register("store.$locale.auth.signin.index", function ($breadcrumbs) use($locale){
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push(Lang::get('users::front.signin'), store_route('store.auth.signin.index'));
        });

        Breadcrumbs::register("store.$locale.auth.signout.index", function ($breadcrumbs) use($locale){
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push(Lang::get('users::front.signout'), store_route('store.auth.signout.index'));
        });

        // SIGNUP

        Breadcrumbs::register("store.$locale.auth.signup.index", function ($breadcrumbs) use($locale){
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push(Lang::get('users::front.signup'), store_route('store.auth.signup.index'));
        });

        Breadcrumbs::register("store.$locale.auth.confirm-email.create", function ($breadcrumbs) use($locale){
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push(Lang::get('users::front.confirm-email'), store_route('store.auth.confirm-email.create'));
        });

        Breadcrumbs::register("store.$locale.auth.confirm-email.show", function ($breadcrumbs) use($locale){
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push(Lang::get('users::front.confirm-email'), store_route('store.auth.confirm-email.show'));
        });

        //FORGOT PASSWORD

        Breadcrumbs::register("store.$locale.auth.forgot-password.index", function ($breadcrumbs) use($locale){
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push(Lang::get('users::front.forgot-password'), store_route('store.auth.forgot-password.index'));
        });

        Breadcrumbs::register("store.$locale.auth.reset-password.show", function ($breadcrumbs) use($locale){
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push(Lang::get('users::front.reset-password'), store_route('store.auth.reset-password.show'));
        });

        //INVITATION

        Breadcrumbs::register("store.$locale.auth.invitation.show", function ($breadcrumbs) use($locale){
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push(Lang::get('users::front.invitation'), store_route('store.auth.invitation.show'));
        });
    }
} else {
    //SIGNIN - SIGNOUT

    Breadcrumbs::register('store.auth.signin.index', function ($breadcrumbs) {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push(Lang::get('users::front.signin'), store_route('store.auth.signin.index'));
    });

    Breadcrumbs::register('store.auth.signout.index', function ($breadcrumbs) {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push(Lang::get('users::front.signout'), store_route('store.auth.signout.index'));
    });

    // SIGNUP

    Breadcrumbs::register('store.auth.signup.index', function ($breadcrumbs) {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push(Lang::get('users::front.signup'), store_route('store.auth.signup.index'));
    });

    Breadcrumbs::register('store.auth.confirm-email.create', function ($breadcrumbs) {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push(Lang::get('users::front.confirm-email'), store_route('store.auth.confirm-email.create'));
    });

    Breadcrumbs::register('store.auth.confirm-email.show', function ($breadcrumbs) {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push(Lang::get('users::front.confirm-email'), store_route('store.auth.confirm-email.show'));
    });

    //FORGOT PASSWORD

    Breadcrumbs::register('store.auth.forgot-password.index', function ($breadcrumbs) {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push(Lang::get('users::front.forgot-password'), store_route('store.auth.forgot-password.index'));
    });

    Breadcrumbs::register('store.auth.reset-password.show', function ($breadcrumbs) {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push(Lang::get('users::front.reset-password'), store_route('store.auth.reset-password.show'));
    });

    //INVITATION

    Breadcrumbs::register('store.auth.invitation.show', function ($breadcrumbs) {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push(Lang::get('users::front.invitation'), store_route('store.auth.invitation.show'));
    });
}