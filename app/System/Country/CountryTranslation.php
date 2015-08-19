<?php

namespace App\System\Country;

use App\System\Translatable\TranslationModel;

class CountryTranslation extends TranslationModel{

    protected $table = "country_translations";

    protected $fillable = ['name'];

    public $timestamps = false;

}