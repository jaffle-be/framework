<?php

// Home > Contact
if (env('APP_MULTIPLE_LOCALES')) {
    foreach (config('system.locales') as $locale) {
        Breadcrumbs::register("store.$locale.contact.index", function ($breadcrumbs) use ($locale) {
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push(Lang::get('contact::front.breadcrumb'), store_route('store.contact.index'));
        });
    }
} else {
    Breadcrumbs::register('store.contact.index', function ($breadcrumbs) {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push(Lang::get('contact::front.breadcrumb'), store_route('store.contact.index'));
    });
}
