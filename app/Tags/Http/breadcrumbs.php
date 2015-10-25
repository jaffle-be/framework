<?php

if(env('APP_MULTIPLE_LOCALES'))
{
    foreach(config('system.locales') as $locale)
    {
        Breadcrumbs::register("store.$locale.tags.show", function($breadcrumbs, $tag) use ($locale){
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push('Tag', store_route("store.tags.show"), [$tag]);
        });
    }
}
else{
    Breadcrumbs::register('store.tags.show', function($breadcrumbs, $tag){
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('Tag', store_route('store.tags.show', [$tag]));
    });
}