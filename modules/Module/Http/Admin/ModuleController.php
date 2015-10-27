<?php namespace Modules\Module\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Module\Module;
use Modules\System\Http\AdminController;

class ModuleController extends AdminController
{

    public function toggle(Request $request, Module $module, AccountManager $manager)
    {
        $module = $module->findOrFail($request->get('id'));

        $account = $manager->account();

        if($request->get('activated'))
        {
            //attach module
            $account->modules()->attach($module->id);

            //broadcast event
            app('pusher')->trigger(pusher_system_channel(), 'system.hard-reload', []);
        }
        else{
            //detach module
            $account->modules()->detach($module->id);

            //broadcast event
            app('pusher')->trigger(pusher_system_channel(), 'system.hard-reload', []);
        }
    }

}