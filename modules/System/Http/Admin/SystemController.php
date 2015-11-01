<?php namespace Modules\System\Http\Admin;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Account\AccountRepositoryInterface;
use Modules\System\Http\AdminController;
use Pusher;

class SystemController extends AdminController
{

    public function index(Repository $config, Application $app)
    {
        //this should return all settings needed for our angular app to work. It might be that this isn't even being called yet.
        return system_options();
    }

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

}