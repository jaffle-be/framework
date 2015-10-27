<?php namespace Modules\System;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

class Locale extends Model
{

    use Translatable;

    protected $table = 'locales';

    protected $fillable = ['slug', 'name'];

    protected $translatedAttributes = ['name'];

    public $timestamps = false;

}