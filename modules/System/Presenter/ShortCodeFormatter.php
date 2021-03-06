<?php

namespace Modules\System\Presenter;

use Modules\Media\Shortcodes\MediaShortcodes;
use Modules\System\Translatable\TranslationModel;

/**
 * Class ShortCodeFormatter
 * @package Modules\System\Presenter
 */
class ShortCodeFormatter
{
    use ShortCodeCompiler;
    use MediaShortcodes;

    protected $shortcodes = ['media'];

    /**
     * This is making sure that shortcodes are always put on their separate lines.
     * if not, they would break the rendering of the markdown.
     * @param $model
     */
    public function handle($model)
    {
        if ($model instanceof TranslationModel && $model instanceof PresentableEntity) {
            if ($model->isDirty('content')) {
                $model->content = $this->formatShortcodes($model->content);
            }
        }
    }
}
