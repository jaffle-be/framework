<?php

namespace Modules\System\Country;

use Modules\System\Translatable\TranslationModel;

class CountryTranslation extends TranslationModel{

    protected $table = "country_translations";

    protected $fillable = ['name'];

    public $timestamps = false;

}