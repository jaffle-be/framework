<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

class PropertyGroup extends Model
{
    use Translatable;

    protected $table = 'product_properties_groups';

    protected $fillable = ['name'];

    protected $translatedAttributes = ['name'];

    protected $translationForeignKey = 'group_id';

    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }

}