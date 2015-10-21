<?php

if(env('APP_MULTIPLE_LOCALES'))
{
    foreach(config('system.locales') as $locale)
    {
        Breadcrumbs::register("$locale.store.tags.show", function($breadcrumbs) use ($locale){
            $breadcrumbs->parent('store.home');
            $breadcrumbs->push('Tag', "$locale.store.blog.show");
        });
    }
}
else{
    Breadcrumbs::register('store.tags.show', function($breadcrumbs){
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('Tag', 'store.blog.show');
    });
}