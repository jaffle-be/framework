<?php namespace App\Theme;

use App\System\Translatable\TranslationModel;

class ThemeSettingOptionTranslation extends TranslationModel
{

    protected $table = 'themes_setting_option_translations';

    protected $fillable = ['name', 'explanation'];
}