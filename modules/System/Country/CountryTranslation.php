<?php

namespace Modules\System\Country;

use Modules\System\Translatable\TranslationModel;

class CountryTranslation extends TranslationModel
{
    public $timestamps = false;

    protected $table = 'country_translations';

    protected $fillable = ['name'];
}
