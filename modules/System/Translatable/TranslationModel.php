<?php namespace Modules\System\Translatable;

use Illuminate\Database\Eloquent\Model;

class TranslationModel extends Model{

    public function newCollection(array $items = [])
    {
        return new SimpleTranslationCollection($items);
    }

}