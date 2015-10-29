<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

class Brand extends Model{

    use Translatable;

    protected $table = 'product_brands';

    protected $fillable = ['name', 'description'];

    protected $translatedAttributes = ['name', 'description'];

    public function products()
    {
        return $this->hasMany('Modules\Shop\Product\Product');
    }

}