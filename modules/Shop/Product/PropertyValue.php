<?php

namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Translatable\Translatable;

class PropertyValue extends Model implements Searchable
{

    use Translatable;
    use SearchableTrait;

    protected $table = 'product_properties_values';

    protected $fillable = ['product_id', 'property_id', 'option_id', 'string', 'numeric', 'float', 'boolean'];

    protected $translatedAttributes = ['string'];

    protected $translationForeignKey = 'value_id';

    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'property_id' => 'integer',
        'option_id' => 'integer',
        'boolean' => 'boolean',
        'numeric' => 'integer',
        'float' => 'float',
    ];

    protected static $searchableMapping = [
        'id' => ['type' => 'integer'],
        'product_id' => ['type' => 'integer'],
        'property_id' => ['type' => 'integer'],
        'option_id' => ['type' => 'integer'],
        'boolean' => ['type' => 'boolean'],
        'numeric' => ['type' => 'integer'],
        'float' => ['type' => 'float'],
        'created_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
        'updated_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
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
