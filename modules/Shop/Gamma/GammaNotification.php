<?php namespace Modules\Shop\Gamma;

use Illuminate\Database\Eloquent\Model;

class GammaNotification extends Model
{

    protected $table = 'product_gamma_notifications';

    protected $fillable = ['account_id', 'brand_selection_id', 'category_selection_id', 'brand_id', 'category_id'];

}