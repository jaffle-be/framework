<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Theme\ThemeManager;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

    public function __construct(ThemeManager $theme)
    {
        $this->theme = $theme;
    }

}
