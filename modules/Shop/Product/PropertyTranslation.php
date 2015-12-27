<?php

namespace Modules\Shop\Product;

use Modules\System\Translatable\TranslationModel;

/**
 * Class PropertyTranslation
 * @package Modules\Shop\Product
 */
class PropertyTranslation extends TranslationModel
{
    protected $table = 'product_properties_translations';

    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property()
    {
        return $this->belongsTo('Modules\Shop\Product\Property', 'property_id');
    }
}
