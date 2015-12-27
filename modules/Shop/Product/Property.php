<?php

namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAutoSort;
use Modules\System\Translatable\Translatable;

/**
 * Class Property
 * @package Modules\Shop\Product
 */
class Property extends Model
{
    use Translatable;
    use ModelAutoSort;

    protected $table = 'product_properties';

    protected $fillable = ['name', 'category_id', 'group_id', 'type', 'unit_id'];

    protected $translatedAttributes = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('Modules\Shop\Product\PropertyGroup', 'group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany('Modules\Shop\Product\PropertyOption', 'property_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo('Modules\Shop\Product\PropertyUnit', 'unit_id');
    }
}
