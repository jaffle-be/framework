<?php namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Pushable\CanPush;
use Modules\System\Pushable\Pushable;
use Modules\System\Scopes\ModelAccountResource;

class GammaSelection extends Model implements Pushable
{

    use ModelAccountResource;
    use CanPush;

    protected $table = 'product_gamma_selections';

    protected $fillable = ['account_id', 'brand_id', 'category_id'];

    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }

    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }

}