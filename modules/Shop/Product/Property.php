<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

class Property extends Model
{
    use Translatable;

    protected $table = 'product_properties';

    protected $fillable = ['name'];

    protected $translatedAttributes = ['name'];

    public function options()
    {
        return $this->hasMany('Modules\Shop\Product\PropertyOption', 'property_id');
    }

    public function unit()
    {
        return $this->belongsTo('Modules\Shop\Product\PropertyUnit', 'unit_id');
    }

}