<?php namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategorySelection extends Model
{
    use SoftDeletes;

    protected $table = "product_gamma_categories";

    protected $fillable = ['category_id'];

    protected $dates = [
        'deleted_at'
    ];

    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }

    public function productSelection()
    {
        return $this->belongsTo('Modules\Shop\Gamma\ProductSelection');
    }

}