<?php

namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Pushable\CanPush;
use Modules\System\Pushable\Pushable;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class GammaSelection
 * @package Modules\Shop\Gamma
 */
class GammaSelection extends Model implements Pushable
{
    use ModelAccountResource;
    use CanPush;

    protected $table = 'product_gamma_selections';

    protected $fillable = ['account_id', 'brand_id', 'category_id'];

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
}
