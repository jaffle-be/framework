<?php namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Scopes\ModelAccountResource;

class CategorySelection extends Model
{
    use ModelAccountResource;

    const ACTIVATE = 'activate';
    const DEACTIVATE = 'deactivate';

    protected $table = 'product_gamma_selected_categories';

    protected $fillable = ['account_id'];

    public function category()
    {
        return $this->belongsTo('Modules\Shop\Product\Category');
    }

}