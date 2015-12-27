<?php

namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class Price
 * @package Modules\Shop\Product
 */
class Price extends Model
{
    use ModelAccountResource;

    protected $table = 'product_prices';

    protected $fillable = ['account_id', 'value', 'active_from', 'active_to'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('Modules\Shop\Product\Product');
    }
}
