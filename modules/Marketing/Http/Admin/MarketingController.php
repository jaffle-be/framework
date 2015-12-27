<?php

namespace Modules\Marketing\Http\Admin;

use Modules\System\Http\AdminController;

class MarketingController extends AdminController
{

    public function overview()
    {
        return view('marketing::admin.overview');
    }
}
