<?php

namespace Modules\Theme;

use Modules\System\Translatable\TranslationModel;

/**
 * Class ThemeSettingOptionTranslation
 * @package Modules\Theme
 */
class ThemeSettingOptionTranslation extends TranslationModel
{
    protected $table = 'themes_setting_option_translations';

    protected $fillable = ['name', 'explanation'];
}
