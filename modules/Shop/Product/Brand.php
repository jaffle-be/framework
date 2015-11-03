<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Pushable\CanPush;
use Modules\System\Pushable\Pushable;
use Modules\System\Translatable\Translatable;

class Brand extends Model implements Pushable{

    use Translatable;
    use CanPush;

    protected $table = 'product_brands';

    protected $fillable = ['name', 'description'];

    protected $translatedAttributes = ['name', 'description'];

    public function products()
    {
        return $this->hasMany('Modules\Shop\Product\Product');
    }

    public function categories()
    {
        return $this->belongsToMany('Modules\Shop\Product\Category', 'product_brands_pivot', null, null, 'brand_categories');
    }

    public function selection()
    {
        //this is meant to be used in an account context.
        return $this->hasOne('Modules\Shop\Gamma\BrandSelection');
    }

    public function toArray()
    {
        $data = parent::toArray();

        if(isset($data['selection']))
        {
            $data['activated'] = (bool) $data['selection'];

            unset($data['selection']);
        }

        return $data;
    }

}