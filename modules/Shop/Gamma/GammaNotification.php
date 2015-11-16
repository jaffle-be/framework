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

    protected $fillable = ['account_id', 'brand_id', 'product_id', 'category_id', 'processing', 'type'];

    protected $casts = [
        'processing' => 'boolean',
    ];

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

    public function scopeNotBeingProcessed($query)
    {
        $query->where('processing', 0);
    }

    public function scopeBeingProcessed($query)
    {
        $query->where('processing', 1);
    }

}