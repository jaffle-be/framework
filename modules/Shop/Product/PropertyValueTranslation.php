<?php namespace Modules\Shop\Product;

use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Translatable\TranslationModel;

class PropertyValueTranslation extends TranslationModel implements Searchable
{

    use SearchableTrait;

    protected $table = 'product_properties_values_translations';

    protected $fillable = ['string'];

    protected static $searchableMapping = [
        'id'         => ['type' => 'integer'],
        'value_id'   => ['type' => 'integer'],
        'string'     => ['type' => 'string'],
        'created_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
        'updated_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
    ];

    public function value()
    {
        return $this->belongsTo('Modules\Shop\Product\PropertyValue', 'value_id');
    }

}