<?php namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

class ActivePrice extends Model
{

    use ModelAccountResource;

    protected $table = 'product_prices_active';

    protected $fillable = ['account_id', 'value', 'activated_on'];

    public function product()
    {
        return $this->belongsTo('Modules\Shop\Product\Product');
    }

}