<?php namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Modules\Search\Model\Searchable;
use Modules\Search\Model\SearchableTrait;
use Modules\System\MySoftDeletes;

class ProductCategorySelection extends Model implements Searchable
{

    use MySoftDeletes;
    use SearchableTrait;

    protected $table = "product_gamma_categories";

    protected $fillable = ['category_id'];

    protected $dates = [
        'deleted_at'
    ];

    protected static $searchableMapping = [
        'created_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
        'updated_at' => [
            'type'   => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
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