<?php namespace Modules\System\Http;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Modules\Theme\ThemeManager;

abstract class Controller extends BaseController
{

    use DispatchesCommands, ValidatesRequests;

    public function __construct(ThemeManager $theme)
    {
        $this->theme = $theme;
    }

}