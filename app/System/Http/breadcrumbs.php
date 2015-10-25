<?php

use App\Blog\PostTranslation;
use App\Pages\PageTranslation;

if(env('APP_MULTIPLE_LOCALES'))
{
    foreach(config('system.locales') as $locale)
    {
        Breadcrumbs::register("store.$locale.uri.show", function($breadcrumbs, $uri, $suburi = null, $subesturi= null) use ($locale){

            if($uri->owner instanceof PostTranslation)
            {
                $breadcrumbs->parent("store.$locale.blog.index");
                $breadcrumbs->push('Post', store_route('store.uri.show', [$uri]));
            }
            elseif($uri->owner instanceof PageTranslation)
            {
                $breadcrumbs->parent("store.$locale.home");
                $breadcrumbs->push('Page');
            }

        });
    }
}
else{
    Breadcrumbs::register('store.uri.show', function($breadcrumbs, $uri, $suburi = null, $subesturi= null){

        if($uri->owner instanceof PostTranslation)
        {
            $breadcrumbs->parent('store.blog.index');
            $breadcrumbs->push('Post', store_route('store.uri.show', [$uri]));
        }
        elseif($uri->owner instanceof PageTranslation)
        {
            $breadcrumbs->parent('store.home');
            $breadcrumbs->push('Page');
        }

    });
}