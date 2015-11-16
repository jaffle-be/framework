<?php

if (env('APP_MULTIPLE_LOCALES')) {
    foreach (config('system.locales') as $locale) {
        Breadcrumbs::register("store.$locale.blog.index", function ($breadcrumbs) use ($locale) {
            $breadcrumbs->parent("store.$locale.home");
            $breadcrumbs->push('News', store_route("store.blog.index"));
        });
    }
} else {
    Breadcrumbs::register('store.blog.index', function ($breadcrumbs) {

        $breadcrumbs->parent('store.home');
        $breadcrumbs->push('News', store_route('store.blog.index'));
    });
}

