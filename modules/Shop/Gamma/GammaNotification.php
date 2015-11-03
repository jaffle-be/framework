<?php namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Pushable\CanPush;
use Modules\System\Pushable\Pushable;
use Modules\System\Scopes\ModelAccountResource;

class GammaNotification extends Model implements Pushable
{
    use ModelAccountResource;
    use CanPush;

    protected $table = 'product_gamma_notifications';

    protected $fillable = ['account_id', 'brand_selection_id', 'category_selection_id', 'brand_id', 'category_id', 'type'];

    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }

    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }

    public function brandSelection()
    {
        return $this->belongsTo('Modules\Shop\Gamma\BrandSelection');
    }

    public function categorySelection()
    {
        return $this->belongsTo('Modules\Shop\Gamma\CategorySelection');
    }

}