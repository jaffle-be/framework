<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Eventing\EventedRelations;
use Modules\System\Pushable\CanPush;
use Modules\System\Pushable\Pushable;
use Modules\System\Translatable\Translatable;

class Category extends Model implements Pushable, Searchable
{

    use Translatable;
    use EventedRelations;
    use CanPush;
    use SearchableTrait;

    protected $table = 'product_categories';

    protected $fillable = ['name'];

    protected $translatedAttributes = ['name'];

    public function selection()
    {
        return $this->hasOne('Modules\Shop\Gamma\CategorySelection');
    }

    public function products()
    {
        return $this->eventedBelongsToMany('Modules\Shop\Product\Product', 'product_categories_pivot', null, null, 'product_categories');
    }

    public function brands()
    {
        return $this->belongsToMany('Modules\Shop\Product\Brand', 'product_brands_pivot', null, null, 'brand_categories');
    }

}