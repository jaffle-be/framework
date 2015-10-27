<?php
use Illuminate\Http\Request;
use Modules\Module\Module;

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

    $options['locales'] = system_locales()->filter(function ($item) {
        return $item->activated == true;
    })->toArray();

    $options['systemModules'] = system_modules()->toArray();

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
    $accountLocales = app('Modules\Account\AccountManager')->account()->locales;

    $systemLocales = Modules\System\Locale::with('translations')->get();

    $systemLocales->each(function ($locale) use ($accountLocales) {
        $locale->activated = $accountLocales->contains($locale->id);
        $locale->active = app()->getLocale();
    });

    return $systemLocales->keyBy('slug');
}

/**
 * Return all supported modules
 *
 * @return \Illuminate\Database\Eloquent\Collection|static[]
 */
function system_modules()
{
    $accountModules = app('Modules\Account\AccountManager')->account()->modules;

    $modules = Module::with('translations')->get();

    $modules->each(function ($module) use ($accountModules) {
        $module->activated = $accountModules->contains($module->id);
    });

    return $modules;
}

function store_route($name, array $arguments = [], $force = null)
{
    if (env('APP_MULTIPLE_LOCALES')) {
        $locale = app()->getLocale();

        $name = str_replace('store.', "store.$locale.", $name);
    }

    if ($force) {
        //replace the current locale with the requested locale
        //added the dots, to make sure we don't replace anything else
        $name = str_replace('.' . app()->getLocale() . '.', '.' . $force . '.', $name);
    }

    return route($name, $arguments);
}

function pusher_system_channel()
{
    $accounts = app('Modules\Account\AccountManager');

    return 'private-' . $accounts->account()->alias;
}

function on_front()
{
    if (app()->runningInConsole()) {
        return false;
    }

    /** @var Request $request */
    $request = app('request');

    return !starts_with($request->getRequestUri(), ['/admin', '/api']);
}

function translation_input(Request $request, array $except = [])
{
    $input = $request->except($except);

    if(isset($input['translations']))
    {
        foreach ($input['translations'] as $locale => $translation) {
            $input[$locale] = $translation;
        }

        unset($input['translations']);
    }

    return $input;
}