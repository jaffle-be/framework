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

    protected $casts = [
        'id'          => 'integer',
        'account_id'  => 'integer',
        'product_id'  => 'integer',
        'brand_id'    => 'integer',
        'category_id' => 'integer',
    ];

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

    /**
     * @param $brand_id
     * @param $category_id
     *
     * @return int
     */
    public function countActiveProducts($brand_id, $category_id)
    {
        return $this->where('brand_id', $brand_id)
            ->where('category_id', $category_id)
            ->count();
    }

}