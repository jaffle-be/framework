<?php

namespace Modules\Shop\Product;

use Modules\System\Translatable\TranslationModel;

class PropertyTranslation extends TranslationModel
{
    protected $table = 'product_properties_translations';

    protected $fillable = ['name'];

    public function property()
    {
        return $this->belongsTo('Modules\Shop\Product\Property', 'property_id');
    }
}
