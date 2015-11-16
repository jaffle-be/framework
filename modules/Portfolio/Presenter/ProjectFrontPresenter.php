<?php namespace Modules\Portfolio\Presenter;

use Modules\Media\Shortcodes\MediaShortcodes;
use Modules\System\Presenter\BasePresenter;
use Modules\System\Presenter\ContentPresenterTrait;
use Modules\System\Presenter\ShortCodeCompiler;

class ProjectFrontPresenter extends BasePresenter
{

    use ShortCodeCompiler;
    use ContentPresenterTrait;
    use MediaShortcodes;

    protected $shortcodes = ['media'];

}