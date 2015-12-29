<?php

namespace Modules\System\Uri;

use Modules\System\Sluggable\OwnsSlug;
use Modules\System\Translatable\Translatable;
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
        if (uses_trait(get_class($model), Translatable::class)) {
            $related = $model->translations()->getRelated();

            if ($related instanceof OwnsSlug) {
                $model->load(['translations', 'translations.slug']);
            }
        }
    }
}
