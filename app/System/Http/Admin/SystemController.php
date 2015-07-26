<?php namespace App\System\Http\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;

class SystemController extends AdminController
{

    public function index(Repository $config, Application $app)
    {
        //this should return all settings needed for our angular app to work.
        return system_options();
    }

}