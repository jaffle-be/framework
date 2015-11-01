<?php namespace Modules\Module\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Module\Module;
use Modules\System\Http\AdminController;
use Pusher;

class ModuleController extends AdminController
{

    public function toggle(Request $request, Module $module, AccountManager $manager, Pusher $pusher)
    {
        $module = $module->findOrFail($request->get('id'));

        $account = $manager->account();

        if($request->get('activated'))
        {
            //attach module
            $account->modules()->attach($module->id);

            //broadcast event
            $pusher->trigger(pusher_account_channel(), 'system.hard-reload', []);
        }
        else{
            //detach module
            $account->modules()->detach($module->id);

            //broadcast event
            $pusher->trigger(pusher_account_channel(), 'system.hard-reload', []);
        }
    }

}