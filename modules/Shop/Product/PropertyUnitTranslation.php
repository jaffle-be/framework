<?php

namespace Modules\Shop\Product;

use Modules\System\Translatable\TranslationModel;

/**
 * Class PropertyUnitTranslation
 * @package Modules\Shop\Product
 */
class PropertyUnitTranslation extends TranslationModel
{
    protected $table = 'product_properties_units_translations';

    protected $fillable = ['name', 'unit'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo('Modules\Shop\Product\PropertyUnit', 'unit_id');
    }
}
