<?php

namespace Modules\System\Http\Admin;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Account\AccountRepositoryInterface;
use Modules\Module\Module;
use Modules\System\Http\AdminController;
use Modules\System\Locale;
use Pusher;

/**
 * Class SystemController
 * @package Modules\System\Http\Admin
 */
class SystemController extends AdminController
{
    /**
     * @param Repository $config
     * @param Application $app
     * @return string
     */
    public function index(Repository $config, Application $app)
    {
        //this should return all settings needed for our angular app to work
        $options['locale'] = $app->getLocale();

        $options['systemLocales'] = $this->system_locales()->toArray();

        $options['locales'] = $this->system_locales()->filter(function ($item) {
            return $item->activated == true;
        })->toArray();

        $options['systemModules'] = $this->system_modules()->toArray();

        return json_encode($options);
    }

    /**
     * @param Request $request
     * @param Guard $guard
     * @param AccountManager $manager
     * @param Pusher $pusher
     * @return string
     */
    public function pusher(Request $request, Guard $guard, AccountManager $manager, Pusher $pusher)
    {
        $user = $guard->user();
        $account = $manager->account();

        //if the user has access to this channel. setup the connection.
        $channelname = $request->get('channel_name');

        $alias = str_replace('private-', '', $channelname);

        //check if the alias equals the current one.
        if ($account->alias == $alias && $account->members->contains($user->id)) {
            return $pusher->socket_auth($request->get('channel_name'), $request->get('socket_id'));
        }
    }

    /**
     * @param Request $request
     * @param AccountManager $accounts
     * @param AccountRepositoryInterface $repository
     * @param Pusher $pusher
     */
    public function locale(Request $request, AccountManager $accounts, AccountRepositoryInterface $repository, Pusher $pusher)
    {
        $account = $accounts->account();

        if ($request->get('activated')) {
            $account->locales()->attach($request->get('id'));
        } else {
            $account->locales()->detach($request->get('id'));
        }

        //bust cache
        $repository->updated();

        //broadcast event
        $pusher->trigger(pusher_account_channel(), 'system.hard-reload', []);
    }

    protected function system_locales()
    {
        $accountLocales = app('Modules\Account\AccountManager')->account()->locales;

        $systemLocales = Locale::with('translations')->get();

        $systemLocales->each(function ($locale) use ($accountLocales) {
            $locale->activated = $accountLocales->contains($locale->id);
            $locale->active = app()->getLocale();
        });

        return $systemLocales->keyBy('slug');
    }

    protected function system_modules()
    {
        $accountModules = app('Modules\Account\AccountManager')->account()->modules;

        $modules = Module::with('translations')->get();

        $modules->each(function ($module) use ($accountModules) {
            $module->activated = $accountModules->contains($module->id);
        });

        return $modules;
    }

}
