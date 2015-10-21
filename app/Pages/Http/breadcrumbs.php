<?php

if (env('APP_MULTIPLE_LOCALES')) {
    foreach (config('system.locales') as $locale) {

        Breadcrumbs::register("$locale.store.pages.show", function ($breadcrumbs, $page) use ($locale) {
            $breadcrumbs->parent('store.home');
            $breadcrumbs->push('Page', route("$locale.store.pages.show"));
        });
    }
} else {
    Breadcrumbs::register('store.pages.show', function ($breadcrumbs, $page) {
        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('Page', route('store.pages.show'));
    });
}
