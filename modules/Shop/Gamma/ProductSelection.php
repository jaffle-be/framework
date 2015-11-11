<?php namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\System\Scopes\ModelAccountResource;

class ProductSelection extends Model
{
    use ModelAccountResource;
    use SoftDeletes;

    protected $table = 'product_gamma';

    protected $fillable = ['account_id', 'product_id', 'brand_id', 'category_id'];

    protected $dates = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo('Modules\Shop\Product\Product');
    }

    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }

    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }

}