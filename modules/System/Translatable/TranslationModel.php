<?php

namespace Modules\System\Translatable;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TranslationModel
 * @package Modules\System\Translatable
 */
class TranslationModel extends Model
{
    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $items
     * @return \Illuminate\Database\Eloquent\Collection
     * @internal param array $models
     */
    public function newCollection(array $items = [])
    {
        return new SimpleTranslationCollection($items);
    }
}
