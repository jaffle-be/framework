<?php

namespace Modules\System\Http;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Modules\Theme\ThemeManager;

/**
 * Class Controller
 * @package Modules\System\Http
 */
abstract class Controller extends BaseController
{
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @param ThemeManager $theme
     */
    public function __construct(ThemeManager $theme)
    {
        $this->theme = $theme;
    }
}
