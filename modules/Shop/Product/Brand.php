<?php

namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\StoresMedia;
use Modules\Media\StoringMedia;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Pushable\CanPush;
use Modules\System\Pushable\Pushable;
use Modules\System\Translatable\Translatable;

class Brand extends Model implements Pushable, Searchable, StoresMedia
{
    use Translatable;
    use CanPush;
    use SearchableTrait;
    use StoringMedia;

    protected $media = 'brands';

    protected $mediaMultiple = false;

    protected $table = 'product_brands';

    protected $fillable = ['name', 'description'];

    protected $translatedAttributes = ['name', 'description'];

    protected static $searchableMapping = [
        'id' => ['type' => 'integer'],
        'created_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
        'updated_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
    ];

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

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $data = parent::toArray();

        if (isset($data['selection'])) {
            $data['activated'] = (bool) $data['selection'];

            unset($data['selection']);
        }

        return $data;
    }
}
