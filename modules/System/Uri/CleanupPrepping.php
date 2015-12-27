<?php

namespace Modules\System\Uri;

use Modules\System\Sluggable\OwnsSlug;
use Modules\System\Translatable\TranslationModel;

/**
 * Class CleanupPrepping
 * @package Modules\System\Uri
 */
class CleanupPrepping
{
    /**
     * @param $model
     */
    public function handle($model)
    {
        if (method_exists($model, 'translations')) {
            $related = $model->translations()->getRelated();

            if ($related instanceof TranslationModel && $related instanceof OwnsSlug) {
                $model->load(['translations', 'translations.slug']);
            }
        }
    }
}
