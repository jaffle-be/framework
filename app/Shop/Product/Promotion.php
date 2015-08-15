<?php namespace App\Shop\Product;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model{

    protected $table = 'product_promotions';

    protected $fillable = ['value'];

}