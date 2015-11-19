<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

class PropertyOption extends Model
{
    use Translatable;

    protected $table = 'product_properties_options';

    protected $fillable = ['name', 'property_id'];

    protected $translatedAttributes = ['name'];

    protected $translationForeignKey = 'option_id';

    public function property()
    {
        return $this->belongsTo('Modules\Shop\Product\Property', 'property_id');
    }

}