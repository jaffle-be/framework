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