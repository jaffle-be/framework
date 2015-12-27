<?php

namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Pushable\CanPush;
use Modules\System\Pushable\Pushable;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class CategorySelection
 * @package Modules\Shop\Gamma
 */
class CategorySelection extends Model implements Pushable
{
    use ModelAccountResource;
    use CanPush;

    const ACTIVATE = 'activate';
    const DEACTIVATE = 'deactivate';

    protected $table = 'product_gamma_selected_categories';

    protected $fillable = ['account_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }
}
