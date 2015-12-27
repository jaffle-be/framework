<?php

namespace Modules\System\Http;

use Modules\Theme\ThemeManager;

class AdminController extends Controller
{
    public function __construct(ThemeManager $theme)
    {
        $this->middleware('auth.admin');

        parent::__construct($theme);
    }
}
