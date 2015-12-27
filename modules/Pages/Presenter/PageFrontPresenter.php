<?php

namespace Modules\Pages\Presenter;

use Modules\Media\Shortcodes\MediaShortcodes;
use Modules\System\Presenter\BasePresenter;
use Modules\System\Presenter\ContentPresenterTrait;
use Modules\System\Presenter\ShortCodeCompiler;

class PageFrontPresenter extends BasePresenter
{
    protected $shortcodes = ['media'];

    use ContentPresenterTrait;
    use ShortCodeCompiler;
    use MediaShortcodes;
}
