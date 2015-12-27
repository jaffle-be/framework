<?php

namespace Modules\System\Http;

use Modules\Theme\ThemeManager;

/**
 * Class AdminController
 * @package Modules\System\Http
 */
class AdminController extends Controller
{
    /**
     * @param ThemeManager $theme
     */
    public function __construct(ThemeManager $theme)
    {
        $this->middleware('auth.admin');

        parent::__construct($theme);
    }
}
