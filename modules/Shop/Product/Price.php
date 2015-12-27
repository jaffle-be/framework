<?php

namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

class Price extends Model
{

    use ModelAccountResource;

    protected $table = 'product_prices';

    protected $fillable = ['account_id', 'value', 'active_from', 'active_to'];

    public function product()
    {
        return $this->belongsTo('Modules\Shop\Product\Product');
    }
}
