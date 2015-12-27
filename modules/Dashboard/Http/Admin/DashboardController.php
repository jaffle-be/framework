<?php

namespace Modules\Dashboard\Http\Admin;

use Modules\System\Http\AdminController;

/**
 * Class DashboardController
 * @package Modules\Dashboard\Http\Admin
 */
class DashboardController extends AdminController
{
    /**
     * @return string
     */
    public function index()
    {
        return 'dashboard';
    }
}
