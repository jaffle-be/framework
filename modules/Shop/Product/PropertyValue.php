<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

class PropertyValue extends Model
{
    use Translatable;

    protected $table = 'product_properties_values';

    protected $fillable = ['string', 'numeric', 'float'];

    protected $translatedAttributes = ['string'];

    protected $translationForeignKey = 'value_id';

    protected $casts = [
        'id' => 'integer',
        'boolean' => 'boelean',
        'numeric' => 'integer',
        'float' => 'float',
    ];

    public function product()
    {
        return $this->belongsTo('Modules\Shop\Product\Product', 'product_id');
    }

    public function property()
    {
        return $this->belongsTo('Modules\Shop\Product\Property', 'property_id');
    }

    public function option()
    {
        return $this->belongsTo('Modules\Shop\Product\PropertyOption', 'option_id');
    }
}