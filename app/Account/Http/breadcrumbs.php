<?php

if(env('APP_MULTIPLE_LOCALES'))
{
    foreach(config('system.locales') as $locale)
    {
        Breadcrumbs::register("store.$locale.team.index", function($breadcrumbs) use ($locale){

            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push('About', store_route('store.team.index'));

        });

        Breadcrumbs::register("store.$locale.team.show", function($breadcrumbs, $member) use ($locale){
            $breadcrumbs->parent("store.$locale.team.index");
            $breadcrumbs->push('Member', store_route("store.team.show", [$member]));
        });

        Breadcrumbs::register("store.$locale.api.admin.account.members.invitation.store", function($breadcrumbs) use ($locale){

            //what is this route used for? it has a really shitty name to begin with.
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push(Lang::get('account::admin.users.invitation'));

        });
    }
}
else{
    Breadcrumbs::register('store.team.index', function($breadcrumbs){
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('About', store_route('store.team.index'));
    });

    Breadcrumbs::register('store.team.show', function($breadcrumbs, $member){
        $breadcrumbs->parent('store.team.index');
        $breadcrumbs->push('Member', store_route('store.team.show', [$member]));
    });

    Breadcrumbs::register('store.api.admin.account.members.invitation.store', function($breadcrumbs){

        $breadcrumbs->parent('store.home');
        $breadcrumbs->push(Lang::get('account::admin.users.invitation'));

    });
}