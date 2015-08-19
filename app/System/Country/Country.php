<?php

namespace App\System\Country;

use Illuminate\Database\Eloquent\Model;

class Country extends Model{

    use \App\System\Translatable\Translatable;

    protected $table = "country";

    protected $useTranslationFallback = true;

    protected $translatedAttributes = [
        'name'
    ];

    protected $fillable = [
        'name',
        'iso_code_2',
        'iso_code_3',
    ];

    public $timestamps = false;

}