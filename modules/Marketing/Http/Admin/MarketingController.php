<?php

namespace Modules\Marketing\Http\Admin;

use Modules\System\Http\AdminController;

/**
 * Class MarketingController
 * @package Modules\Marketing\Http\Admin
 */
class MarketingController extends AdminController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview()
    {
        return view('marketing::admin.overview');
    }
}
