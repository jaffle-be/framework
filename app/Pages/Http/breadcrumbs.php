<?php

if (env('APP_MULTIPLE_LOCALES')) {
    foreach (config('system.locales') as $locale) {

        Breadcrumbs::register("store.$locale.pages.show", function ($breadcrumbs, $page) use ($locale) {
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push('Page', store_route("store.pages.show"));
        });
    }
} else {
    Breadcrumbs::register('store.pages.show', function ($breadcrumbs, $page) {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('Page', store_route('store.pages.show'));
    });
}
