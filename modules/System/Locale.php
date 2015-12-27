<?php

namespace Modules\System;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

/**
 * Class Locale
 * @package Modules\System
 */
class Locale extends Model
{
    use Translatable;

    public $timestamps = false;

    protected $table = 'locales';

    protected $fillable = ['slug', 'name'];

    protected $translatedAttributes = ['name'];
}
