<?php namespace App\System\Http;

use App\Theme\ThemeManager;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

    public function __construct(ThemeManager $theme)
    {
        $this->theme = $theme;
    }

}