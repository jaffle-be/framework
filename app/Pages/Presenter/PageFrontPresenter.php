<?php namespace App\Pages\Presenter;

use App\Media\Image;
use App\Media\Shortcodes\MediaShortcodes;
use App\System\Presenter\BasePresenter;
use App\System\Presenter\ContentPresenterTrait;
use App\System\Presenter\ShortCodeCompiler;

class PageFrontPresenter extends BasePresenter
{
    protected $shortcodes = ['media'];

    use ContentPresenterTrait;
    use ShortCodeCompiler;
    use MediaShortcodes;

}