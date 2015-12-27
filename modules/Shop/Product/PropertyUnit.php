<?php

namespace Modules\Shop\Product;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

class PropertyUnit extends Model
{
    use Translatable;

    protected $table = 'product_properties_units';

    protected $fillable = ['name', 'unit'];

    protected $translatedAttributes = ['name', 'unit'];

    protected $translationForeignKey = 'unit_id';
}
