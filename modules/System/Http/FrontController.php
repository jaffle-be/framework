<?php

namespace Modules\System\Http;

use Modules\System\Seo\SeoManager;
use Modules\Theme\ThemeManager;

/**
 * Class FrontController
 * @package Modules\System\Http
 */
abstract class FrontController extends Controller
{
    /**
     * @param ThemeManager $theme
     * @param SeoManager $seo
     */
    public function __construct(ThemeManager $theme, SeoManager $seo)
    {
        parent::__construct($theme);

        $this->seo = $seo;
    }
}
