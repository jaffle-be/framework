<?php

namespace Modules\Shop\Product;

use Modules\System\Translatable\TranslationModel;

class PropertyOptionTranslation extends TranslationModel
{
    protected $table = 'product_properties_options_translations';

    protected $fillable = ['name'];

    public function option()
    {
        return $this->belongsTo('Modules\Shop\Product\ProductOption', 'option_id');
    }
}
