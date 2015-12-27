<?php

namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Pushable\CanPush;
use Modules\System\Pushable\Pushable;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class BrandSelection
 * @package Modules\Shop\Gamma
 */
class BrandSelection extends Model implements Pushable
{
    use ModelAccountResource;
    use CanPush;

    protected $table = 'product_gamma_selected_brands';

    protected $fillable = ['account_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }
}
