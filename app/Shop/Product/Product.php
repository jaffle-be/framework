<?php namespace App\Shop\Product;

use App\Media\StoresMedia;
use App\Media\StoringMedia;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements StoresMedia{

    use StoringMedia;

    protected $table = 'products';

    protected $fillable = ['name', 'text'];


    public function getMediaFolder()
    {
        return sprintf('products/%d/%d/', $this->attributes['brand_id'], $this->attributes['id']);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function images()
    {
        return $this->morphMany('App\Media\Image', 'owner');
    }

    public function price()
    {
        return $this->hasMany('App\Shop\Product\Price');
    }

    public function promotion()
    {
        return $this->hasMany('App\Shop\Product\Promotion');
    }

    public function brand()
    {
        return $this->belongsTo('App\Shop\Product\Brand');
    }

}