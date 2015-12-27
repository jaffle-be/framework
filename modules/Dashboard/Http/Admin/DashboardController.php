<?php

namespace Modules\Dashboard\Http\Admin;

use Modules\System\Http\AdminController;

class DashboardController extends AdminController
{
    public function index()
    {
        return 'dashboard';
    }
}
