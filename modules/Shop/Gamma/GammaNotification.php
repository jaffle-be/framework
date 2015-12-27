<?php

namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Pushable\CanPush;
use Modules\System\Pushable\Pushable;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class GammaNotification
 * @package Modules\Shop\Gamma
 */
class GammaNotification extends Model implements Pushable
{
    use ModelAccountResource;
    use CanPush;

    protected $table = 'product_gamma_notifications';

    protected $fillable = ['account_id', 'brand_id', 'product_id', 'category_id', 'processing', 'type'];

    protected $casts = [
        'processing' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('Modules\Shop\Product\Product');
    }

    /**
     * @param $query
     */
    public function scopeNotBeingProcessed($query)
    {
        $query->where('processing', 0);
    }

    /**
     * @param $query
     */
    public function scopeBeingProcessed($query)
    {
        $query->where('processing', 1);
    }
}
