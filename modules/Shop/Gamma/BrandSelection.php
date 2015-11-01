<?php namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

class BrandSelection extends Model
{
    use ModelAccountResource;

    const ACTIVATE = 'activate';
    const DEACTIVATE = 'deactivate';

    protected $table = 'product_gamma_selected_brands';

    protected $fillable = ['account_id'];

    public function brand()
    {
        return $this->belongsTo('Modules\Shop\Product\Brand');
    }

}