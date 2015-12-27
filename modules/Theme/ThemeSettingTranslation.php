<?php

namespace Modules\Theme;

use Modules\System\Translatable\TranslationModel;

/**
 * Class ThemeSettingTranslation
 * @package Modules\Theme
 */
class ThemeSettingTranslation extends TranslationModel
{
    protected $table = 'themes_setting_key_translations';

    protected $fillable = ['name', 'explanation'];
}
