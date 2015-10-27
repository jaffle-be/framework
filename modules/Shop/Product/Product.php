<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\Media\StoresMedia;
use Modules\Media\StoringMedia;

class Product extends Model implements StoresMedia{

    use StoringMedia;

    protected $table = 'products';

    protected $fillable = ['name', 'text'];


    public function getMediaFolder($type = null, $size = null)
    {
        if(!in_array($type, ['files', 'images', 'videos', 'infographics']))
        {
            throw new InvalidArgumentException('need proper media type to return media folder');
        }

        if(!$size)
        {
            sprintf('products/%d/%d/', $this->attributes['brand_id'], $this->attributes['id']);
        }

        return sprintf('products/%d/%d/%s', $this->attributes['brand_id'], $this->attributes['id']);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function images()
    {
        return $this->morphMany('Modules\Media\Image', 'owner');
    }

    public function price()
    {
        return $this->hasMany('Modules\Shop\Product\Price');
    }

    public function promotion()
    {
        return $this->hasMany('Modules\Shop\Product\Promotion');
    }

    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }

}