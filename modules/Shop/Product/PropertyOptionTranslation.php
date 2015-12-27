<?php

namespace Modules\Shop\Product;

use Modules\System\Translatable\TranslationModel;

/**
 * Class PropertyOptionTranslation
 * @package Modules\Shop\Product
 */
class PropertyOptionTranslation extends TranslationModel
{
    protected $table = 'product_properties_options_translations';

    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option()
    {
        return $this->belongsTo('Modules\Shop\Product\ProductOption', 'option_id');
    }
}
