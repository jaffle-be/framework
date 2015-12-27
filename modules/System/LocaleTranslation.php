<?php

namespace Modules\System;

use Modules\System\Translatable\TranslationModel;

/**
 * Class LocaleTranslation
 * @package Modules\System
 */
class LocaleTranslation extends TranslationModel
{
    public $timestamps = false;

    protected $table = 'locales_translations';

    protected $fillable = ['name'];
}
