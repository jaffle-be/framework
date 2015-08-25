<?php namespace App\System\Http\Admin;

use App\Account\AccountManager;
use App\Account\AccountRepositoryInterface;
use App\System\Http\AdminController;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class SystemController extends AdminController
{

    public function index(Repository $config, Application $app)
    {
        //this should return all settings needed for our angular app to work. It might be that this isn't even being called yet.
        return system_options();
    }

    public function locale(Request $request, AccountManager $accounts, AccountRepositoryInterface $repository)
    {
        $account = $accounts->account();

        if($request->get('activated'))
        {
            $account->locales()->attach($request->get('id'));
        }
        else{
            $account->locales()->detach($request->get('id'));
        }

        //bust cache
        $repository->updated();
    }

}