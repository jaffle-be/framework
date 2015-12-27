<?php

namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class ActivePromotion
 * @package Modules\Shop\Product
 */
class ActivePromotion extends Model
{
    use ModelAccountResource;

    protected $table = 'product_promotions_active';

    protected $fillable = ['account_id', 'brand_id', 'category_id', 'product_id', 'absolute', 'activated_on', 'value', 'from', 'to'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('Modules\Shop\Product\Product');
    }
}
