<?php namespace App\System;

use App\System\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{

    use Translatable;

    protected $table = 'locales';

    protected $fillable = ['slug', 'name'];

    protected $translatedAttributes = ['name'];

    public $timestamps = false;

}