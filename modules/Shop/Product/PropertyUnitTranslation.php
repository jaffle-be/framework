<?php namespace Modules\Shop\Product;

use Modules\System\Translatable\TranslationModel;

class PropertyUnitTranslation extends TranslationModel
{

    protected $table = 'product_properties_units_translations';

    protected $fillable = ['name', 'unit'];

    public function unit()
    {
        return $this->belongsTo('Modules\Shop\Product\PropertyUnit', 'unit_id');
    }

}