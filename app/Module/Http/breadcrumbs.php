<?php

if(env('APP_MULTIPLE_LOCALES'))
{
    foreach(config('system.locales') as $locale)
    {
        Breadcrumbs::register("store.$locale.module.index", function($breadcrumbs) use ($locale){
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push('News' , route("store.$locale.module.index"));
        });
    }
}
else{
    Breadcrumbs::register('store.module.index', function($breadcrumbs){

        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('News' , route('store.module.index'));

    });
}