<?php
if(env('APP_MULTIPLE_LOCALES'))
{

    foreach(config('system.locales') as $locale)
    {
        Breadcrumbs::register("store.$locale.portfolio.index", function($breadcrumbs) use ($locale){
            $breadcrumbs->parent('store.home');
            $breadcrumbs->push('Projects', store_route("store.portfolio.index"));
        });


        Breadcrumbs::register("store.$locale.portfolio.show", function($breadcrumbs) use ($locale){
            $breadcrumbs->parent("store.$locale.portfolio.index");
            $breadcrumbs->push('Project', store_route("store.portfolio.index"));
        });
    }
}
else
{

    Breadcrumbs::register('store.portfolio.index', function($breadcrumbs){
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('Projects', store_route('store.portfolio.index'));
    });


    Breadcrumbs::register('store.portfolio.show', function($breadcrumbs){
        $breadcrumbs->parent('store.portfolio.index');
        $breadcrumbs->push('Project', store_route('store.portfolio.index'));
    });
}