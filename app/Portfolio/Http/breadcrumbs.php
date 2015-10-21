<?php
if(env('APP_MULTIPLE_LOCALES'))
{

    foreach(config('system.locales') as $locale)
    {
        Breadcrumbs::register("$locale.store.portfolio.index", function($breadcrumbs) use ($locale){
            $breadcrumbs->parent('store.home');
            $breadcrumbs->push('Projects', route("$locale.store.portfolio.index"));
        });


        Breadcrumbs::register("$locale.store.portfolio.show", function($breadcrumbs) use ($locale){
            $breadcrumbs->parent("$locale.store.portfolio.index");
            $breadcrumbs->push('Project', route("$locale.store.portfolio.index"));
        });
    }
}
else
{

    Breadcrumbs::register('store.portfolio.index', function($breadcrumbs){
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('Projects', route('store.portfolio.index'));
    });


    Breadcrumbs::register('store.portfolio.show', function($breadcrumbs){
        $breadcrumbs->parent('store.portfolio.index');
        $breadcrumbs->push('Project', route('store.portfolio.index'));
    });
}