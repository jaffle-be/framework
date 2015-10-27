<?php

if(env('APP_MULTIPLE_LOCALES'))
{
    foreach (config('system.locales') as $locale) {
        // Home
        Breadcrumbs::register("store.$locale.home", function($breadcrumbs)
        {
            $breadcrumbs->push('Home', store_route('store.home'));
        });
    }
}
else{
    // Home
    Breadcrumbs::register('store.home', function($breadcrumbs)
    {
        $breadcrumbs->push('Home', store_route('store.home'));
    });
}