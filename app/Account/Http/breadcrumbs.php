<?php

if(env('APP_MULTIPLE_LOCALES'))
{
    foreach(config('system.locales') as $locale)
    {
        Breadcrumbs::register("$locale.store.team.index", function($breadcrumbs){

            $breadcrumbs->parent('store.home');
            $breadcrumbs->push('About', route('store.team.index'));

        });

        Breadcrumbs::register("$locale.store.team.show", function($breadcrumbs) use ($locale){
            $breadcrumbs->parent("$locale.store.team.index");
            $breadcrumbs->push('Member', route("$locale.store.team.show"));
        });
    }
}
else{
    Breadcrumbs::register('store.team.index', function($breadcrumbs){
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('About', route('store.team.index'));
    });

    Breadcrumbs::register('store.team.show', function($breadcrumbs){
        $breadcrumbs->parent('store.team.index');
        $breadcrumbs->push('Member', route('store.team.show'));
    });
}

Breadcrumbs::register('store.api.admin.account.members.invitation.store', function($breadcrumbs){

    $breadcrumbs->parent('store.home');
    $breadcrumbs->push(Lang::get('account::admin.users.invitation'));

});