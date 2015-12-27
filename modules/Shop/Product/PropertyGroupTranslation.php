<?php

namespace Modules\Shop\Product;

use Modules\System\Translatable\TranslationModel;

/**
 * Class PropertyGroupTranslation
 * @package Modules\Shop\Product
 */
class PropertyGroupTranslation extends TranslationModel
{
    protected $table = 'product_properties_groups_translations';

    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('Modules\Shop\Product\PropertyGroup');
    }
}
