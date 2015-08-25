<?php

/**
 * Used to help set the configuration through json on the front side.
 * Found in the actual views, will most likely be at the same html element
 * where the angular page specific controller is assigned
 *
 * @return string
 */
function system_options()
{
    $options['locale'] = app()->getLocale();

    $options['systemLocales'] = system_locales()->toArray();

    $options['locales'] = system_locales()->filter(function($item){
        return $item->activated == true;
    })->toArray();

    $options['summernote'] = config('system.summernote');

    return json_encode($options);
}

/**
 * Return all supported locales
 *
 * It also contains extra info about which locales are activated and which not.
 * This helps us use that information in the admin in angular using the ng-init approach.
 * ng-init is not ideal, but it should do for now.
 *
 * @return \Illuminate\Database\Eloquent\Collection|static[]
 */
function system_locales()
{
    $accountLocales = app('App\Account\AccountManager')->account()->locales;

    $systemLocales = App\System\Locale::with('translations')->get();

    $systemLocales->each(function ($locale) use ($accountLocales) {
        $locale->activated = $accountLocales->contains($locale->id);
        $locale->active = app()->getLocale();
    });

    return $systemLocales->keyBy('slug');
}