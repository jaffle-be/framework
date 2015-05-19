<?php namespace App\Shop\Product;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model{

    protected $table = 'product_brands';

    protected $fillable = ['name'];

}