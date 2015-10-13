<?php namespace App\Portfolio\Presenter;

use App\Media\Shortcodes\MediaShortcodes;
use App\System\Presenter\BasePresenter;
use App\System\Presenter\ContentPresenterTrait;
use App\System\Presenter\ShortCodeCompiler;

class ProjectFrontPresenter extends BasePresenter
{
    use ShortCodeCompiler;
    use ContentPresenterTrait;
    use MediaShortcodes;

    protected $shortcodes = ['media'];

    protected $contentPresenterField = 'description';

}