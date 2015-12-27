<?php

namespace Modules\System\Translatable;

use Illuminate\Database\Eloquent\Model;

class TranslationModel extends Model
{
    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $items = [])
    {
        return new SimpleTranslationCollection($items);
    }
}
