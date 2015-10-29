<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

class Category extends Model
{

    use Translatable;

    protected $table = 'product_categories';

    protected $fillable = ['name'];

    protected $translatedAttributes = ['name'];

}