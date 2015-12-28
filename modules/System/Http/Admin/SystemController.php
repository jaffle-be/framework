<?php

namespace Modules\System\Http\Admin;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Account\AccountRepositoryInterface;
use Modules\Media\MediaWidgetPreperations;
use Modules\Module\Module;
use Modules\System\Http\AdminController;
use Modules\System\Locale;
use Modules\Users\Jobs\CheckGravatarImage;
use Pusher;

/**
 * Class SystemController
 * @package Modules\System\Http\Admin
 */
class SystemController extends AdminController
{
    use MediaWidgetPreperations;
    /**
     * @param Repository $config
     * @param Application $app
     * @return string
     */
    public function index(Repository $config, Application $app, AccountManager $account, Guard $guard)
    {
        //this should return all settings needed for our angular app to work
        return json_encode([
            'options' => $this->systemInfo($app),
            'user' => $this->userInfo($guard),
            'pusher' => $this->pusherInfo($account),
        ]);
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

    /**
     * @param Guard $guard
     * @return mixed
     */
    protected function userInfo(Guard $guard)
    {
        $user = $guard->user();

        if ($user->images->count() == 0) {
            $this->dispatch(new CheckGravatarImage($user));
        }

        $user->load(['translations', 'skills', 'skills.translations']);

        $this->prepareImages($user);

        return $user;
    }

    /**
     * @param AccountManager $account
     * @return array
     */
    protected function pusherInfo(AccountManager $account)
    {
        return [
            'channel' => $account->account()->alias,
            'apikey' => env('PUSHER_API_KEY')
        ];
    }

    /**
     * @param Application $app
     * @return mixed
     */
    protected function systemInfo(Application $app)
    {
        return [
            'locale' => $app->getLocale(),

            'systemLocales' => $this->system_locales()->toArray(),

            'locales' => $this->system_locales()->filter(function ($item) {
                return $item->activated == true;
            })->toArray(),

            'systemModules' => $this->system_modules()->toArray(),
        ];
    }

}
