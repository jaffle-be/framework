<?php

namespace Modules\System\Presenter;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PresentableCacher
 * @package Modules\System\Presenter
 */
class PresentableCacher
{
    /**
     * @param $model
     */
    public function handle($model)
    {
        if ($model instanceof PresentableEntity && $model instanceof PresentableCache) {
            /** @var Model $model */
            if ($model->isDirty('content')) {
                $content = $model->present()->content;

                $model->cached_content = $content;
                $model->cached_extract = $model->present()->extract;
            }
        }
    }
}
