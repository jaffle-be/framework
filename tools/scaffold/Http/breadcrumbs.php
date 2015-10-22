<?php

if(env('APP_MULTIPLE_LOCALES'))
{
    foreach(config('system.locales') as $locale)
    {
        Breadcrumbs::register("store.$locale.blog.index", function($breadcrumbs) use ($locale){
            $breadcrumbs->parent('store.home');
            $breadcrumbs->push('News' , route("store.$locale.blog.index"));
        });
    }
}
else{
    Breadcrumbs::register('store.blog.index', function($breadcrumbs){

        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('News' , route('store.blog.index'));

    });
}