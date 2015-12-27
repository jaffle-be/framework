<?php

namespace Modules\System\Country;

use Modules\System\Translatable\TranslationModel;

/**
 * Class CountryTranslation
 * @package Modules\System\Country
 */
class CountryTranslation extends TranslationModel
{
    public $timestamps = false;

    protected $table = 'country_translations';

    protected $fillable = ['name'];
}
