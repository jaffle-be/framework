<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;

class Price extends Model{

    protected $table = 'product_prices';

    protected $fillable = ['value'];

}