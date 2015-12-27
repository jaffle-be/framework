<?php

namespace Modules\Shop\Product;

use Modules\System\Translatable\TranslationModel;

class PropertyGroupTranslation extends TranslationModel
{
    protected $table = 'product_properties_groups_translations';

    protected $fillable = ['name'];

    public function group()
    {
        return $this->belongsTo('Modules\Shop\Product\PropertyGroup');
    }
}
