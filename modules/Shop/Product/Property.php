<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

class Property extends Model
{
    use Translatable;

    protected $table = 'product_properties';

    protected $fillable = ['name'];

    protected $translatedAttributes = ['name'];

    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category', 'category_id');
    }

    public function group()
    {
        return $this->belongsTo('Modules\Shop\Product\PropertyGroup', 'group_id');
    }

    public function options()
    {
        return $this->hasMany('Modules\Shop\Product\PropertyOption', 'property_id');
    }

    public function unit()
    {
        return $this->belongsTo('Modules\Shop\Product\PropertyUnit', 'unit_id');
    }

    public static function categoryProperties($category)
    {
        return static::query()
            ->with(['translations', 'options', 'options.translations', 'unit', 'unit.translations'])
            ->where('category_id', $category->id)
            ->get();
    }

}