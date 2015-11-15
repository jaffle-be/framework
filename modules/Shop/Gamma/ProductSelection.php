<?php namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\MySoftDeletes;
use Modules\System\Scopes\ModelAccountResource;

class ProductSelection extends Model implements Searchable
{

    use MySoftDeletes;
    use SearchableTrait;
    use ModelAccountResource;

    protected $table = 'product_gamma';

    protected $fillable = ['account_id', 'product_id', 'brand_id'];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'id'          => 'integer',
        'account_id'  => 'integer',
        'product_id'  => 'integer',
        'brand_id'    => 'integer',
        'category_id' => 'integer',
    ];

    protected static $searchableMapping = [
        'id'          => ['type' => 'integer'],
        'account_id'  => ['type' => 'integer'],
        'product_id'  => ['type' => 'integer'],
        'brand_id'    => ['type' => 'integer'],
    ];

    public function product()
    {
        return $this->belongsTo('Modules\Shop\Product\Product');
    }

    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }

    public function categories()
    {
        return $this->hasMany('Modules\Shop\Gamma\ProductCategorySelection', 'selection_id');
    }

    public function activePrice()
    {
        return $this->belongsTo('Modules\Shop\Product\ActivePrice');
    }

    public function activePromotion()
    {
        return $this->belongsTo('Modules\Shop\Product\ActivePromotion');
    }

    /**
     * @param $brand_id
     * @param $category_id
     *
     * @return int
     */
    public function countActiveProducts($brand_id, $category_id, $account_id)
    {
        return $this->newQueryWithoutScopes()
            ->join('product_gamma_categories', 'product_gamma.id', '=', 'product_gamma_categories.selection_id')
            ->where('brand_id', $brand_id)
            ->where('category_id', $category_id)
            ->where('account_id', $account_id)
            //need to set this ourselves, (using whereHas didnt seem to resolve this.)
            ->whereNull('product_gamma_categories.deleted_at')
            ->count();
    }

    public function chunkActiveProducts($brand_id, $category_id, $account_id)
    {
        return $this->newQueryWithoutScopes()
            ->join('product_gamma_categories', 'product_gamma.id', '=', 'product_gamma_categories.selection_id')
            ->where('brand_id', $brand_id)
            ->where('category_id', $category_id)
            ->where('account_id', $account_id)
            ->whereNull('product_gamma_categories.deleted_at')
            ->take(200)->get(['product_gamma.*']);
    }

}