<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Theme\Contracts\Theme;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

}
