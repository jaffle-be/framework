<?php

namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

class ActivePromotion extends Model
{

    use ModelAccountResource;

    protected $table = 'product_promotions_active';

    protected $fillable = ['account_id', 'brand_id', 'category_id', 'product_id', 'absolute', 'activated_on', 'value', 'from', 'to'];

    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }

    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }

    public function product()
    {
        return $this->belongsTo('Modules\Shop\Product\Product');
    }
}
