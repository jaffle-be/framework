<?php

namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class ActivePrice
 * @package Modules\Shop\Product
 */
class ActivePrice extends Model
{
    use ModelAccountResource;

    protected $table = 'product_prices_active';

    protected $fillable = ['account_id', 'value', 'activated_on'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('Modules\Shop\Product\Product');
    }
}
