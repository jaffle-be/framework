<?php namespace App\System\Presenter;

use App\Media\Shortcodes\MediaShortcodes;
use App\System\Translatable\TranslationModel;

class ShortCodeFormatter
{
    use ShortCodeCompiler;
    use MediaShortcodes;

    protected $shortcodes = ['media'];

    /**
     * This is making sure that shortcodes are always put on their separate lines.
     * if not, they would break the rendering of the markdown.
     *
     * @param $model
     */
    public function handle($model)
    {
        if($model instanceof TranslationModel && $model instanceof PresentableEntity)
        {
            if($model->isDirty('content'))
            {
                $model->content = $this->formatShortcodes($model->content);
            }
        }
    }

}