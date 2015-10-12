<?php namespace App\System\Http;

use App\Theme\ThemeManager;

abstract class FrontController extends Controller {

    public function __construct(ThemeManager $theme)
    {
        parent::__construct($theme);
    }

}