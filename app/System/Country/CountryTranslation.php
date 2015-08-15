<?php

namespace App\System\Country;

use Jaffle\Tools\TranslationModel;

class CountryTranslation extends TranslationModel{

    protected $table = "country_translations";

    protected $fillable = ['name'];

    public $timestamps = false;

}