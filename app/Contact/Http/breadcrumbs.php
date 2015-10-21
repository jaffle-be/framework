<?php

// Home > Contact
if(env('APP_MULTIPLE_LOCALES'))
{
    foreach(config('system.locales') as $locale)
    {
        Breadcrumbs::register("$locale.store.contact.index", function($breadcrumbs) use ($locale)
        {
            $breadcrumbs->parent('store.home');
            $breadcrumbs->push(Lang::get('contact::front.breadcrumb'), route("$locale.store.contact.index"));
        });
    }
}
else{
    Breadcrumbs::register('store.contact.index', function($breadcrumbs)
    {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push(Lang::get('contact::front.breadcrumb'), route('store.contact.index'));
    });
}
