<?php

namespace Modules\System\Translatable;

use Illuminate\Database\Eloquent\Collection;

class SimpleTranslationCollection extends Collection
{

    public function toArray()
    {
        return with(new Collection($this->items))->keyBy('locale')->toArray();
    }

    public function toJson($options = 0)
    {
        return parent::toJson(JSON_FORCE_OBJECT);
    }
}
