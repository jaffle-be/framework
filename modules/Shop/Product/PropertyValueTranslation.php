<?php namespace Modules\Shop\Product;

use Modules\System\Translatable\TranslationModel;

class PropertyValueTranslation extends TranslationModel
{

    protected $table = 'product_properties_values_translations';

    protected $fillable = ['string'];

    public function value()
    {
        return $this->belongsTo('Modules\Shop\Product\PropertyValue', 'value_id');
    }

}