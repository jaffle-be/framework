<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAutoSort;
use Modules\System\Translatable\Translatable;

class PropertyGroup extends Model
{
    use Translatable;
    use ModelAutoSort;

    protected $table = 'product_properties_groups';

    protected $fillable = ['name', 'category_id'];

    protected $translatedAttributes = ['name'];

    protected $translationForeignKey = 'group_id';

    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }

}