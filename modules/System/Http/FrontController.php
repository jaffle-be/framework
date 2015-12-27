<?php

namespace Modules\System\Http;

use Modules\System\Seo\SeoManager;
use Modules\Theme\ThemeManager;

abstract class FrontController extends Controller
{

    public function __construct(ThemeManager $theme, SeoManager $seo)
    {
        parent::__construct($theme);

        $this->seo = $seo;
    }
}
