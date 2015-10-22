<?php namespace App\System\Http;

use App\System\Seo\SeoManager;
use App\Theme\ThemeManager;

abstract class FrontController extends Controller {

    public function __construct(ThemeManager $theme, SeoManager $seo)
    {
        parent::__construct($theme);

        $this->seo = $seo;
    }

}