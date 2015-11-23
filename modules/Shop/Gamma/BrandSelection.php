<?php namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Pushable\CanPush;
use Modules\System\Pushable\Pushable;
use Modules\System\Scopes\ModelAccountResource;

class BrandSelection extends Model implements Pushable
{

    use ModelAccountResource;
    use CanPush;

    protected $table = 'product_gamma_selected_brands';

    protected $fillable = ['account_id'];

    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }

}