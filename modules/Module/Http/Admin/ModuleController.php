<?php

namespace Modules\Module\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Module\Module;
use Modules\System\Http\AdminController;
use Pusher;

/**
 * Class ModuleController
 * @package Modules\Module\Http\Admin
 */
class ModuleController extends AdminController
{
    /**
     * @param Request $request
     * @param Module $module
     * @param AccountManager $manager
     * @param Pusher $pusher
     */
    public function toggle(Request $request, Module $module, AccountManager $manager, Pusher $pusher)
    {
        $module = $module->findOrFail($request->get('id'));

        $account = $manager->account();

        if ($request->get('activated')) {
            //attach module
            $account->modules()->attach($module->id);

            //broadcast event
            $pusher->trigger(pusher_account_channel(), 'system.hard-reload', []);
        } else {
            //detach module
            $account->modules()->detach($module->id);

            //broadcast event
            $pusher->trigger(pusher_account_channel(), 'system.hard-reload', []);
        }
    }
}
