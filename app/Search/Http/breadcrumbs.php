<?php

if(env('APP_MULTIPLE_LOCALES'))
{
    foreach(config('system.locales') as $locale)
    {
        Breadcrumbs::register("store.$locale.search.index", function($breadcrumbs) use ($locale){

            $breadcrumbs->parent('store.home');
            $breadcrumbs->push('Find' , store_route("store.search.index"));
        });
    }
}
else{

    Breadcrumbs::register('store.search.index', function($breadcrumbs){

        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('Find' , store_route('store.search.index'));

    });
}