<?php

namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\Media\StoresMedia;
use Modules\Media\StoringMedia;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\Eventing\EventedRelations;
use Modules\System\Presenter\PresentableEntity;
use Modules\System\Presenter\PresentableTrait;
use Modules\System\Scopes\FrontScoping;
use Modules\System\Seo\SeoEntity;
use Modules\System\Seo\SeoTrait;
use Modules\System\Translatable\Translatable;
use Modules\Tags\Taggable;

class Product extends Model implements StoresMedia, PresentableEntity, SeoEntity, Searchable
{
    use Translatable, StoringMedia, PresentableTrait, FrontScoping, SeoTrait, Taggable, EventedRelations, SearchableTrait;

    protected $table = 'products';

    protected $fillable = ['account_id', 'brand_id', 'ean', 'upc', 'name', 'title', 'content', 'published'];

    protected $translatedAttributes = ['name', 'title', 'content', 'published'];

    protected $presenter = 'Modules\Shop\Presenter\ProductFrontPresenter';

    protected $casts = [
        'id' => 'integer',
        'account_id' => 'integer',
        'brand_id' => 'integer',
    ];

    protected static $searchableMapping = [
        'id' => ['type' => 'integer'],
        'account_id' => ['type' => 'integer'],
        'brand_id' => ['type' => 'integer'],
        'created_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
        'updated_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss',
        ],
    ];

    public function getMediaFolder($type = null, $size = null)
    {
        if (!empty($type) && !in_array($type, ['files', 'images', 'videos', 'infographics'])) {
            throw new InvalidArgumentException('need proper media type to return media folder');
        }

        if (!$size) {
            sprintf('products/%d/%d/', $this->attributes['brand_id'], $this->attributes['id']);
        }

        return sprintf('products/%d/%d/%s/', $this->attributes['brand_id'], $this->attributes['id'], $size);
    }

    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }

    public function categories()
    {
        return $this->eventedBelongsToMany('Modules\Shop\Product\Category', 'product_categories_pivot', null, null, 'product_categories');
    }

    public function mainCategory()
    {
        return $this->categories->first(function ($key, $item) {
            return !$item->original_id;
        });
    }

    public function price()
    {
        return $this->hasOne('Modules\Shop\Product\ActivePrice');
    }

    public function priceHistory()
    {
        return $this->hasMany('Modules\Shop\Product\Price');
    }

    public function promotion()
    {
        return $this->hasOne('Modules\Shop\Product\ActivePromotion');
    }

    public function promotionHistory()
    {
        return $this->hasMany('Modules\Shop\Product\Promotion');
    }

    public function properties()
    {
        return $this->hasMany('Modules\Shop\Product\PropertyValue');
    }
}
