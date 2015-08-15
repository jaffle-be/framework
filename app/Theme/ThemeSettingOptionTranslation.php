<?php namespace App\Theme;

use Jaffle\Tools\TranslationModel;

class ThemeSettingOptionTranslation extends TranslationModel
{

    protected $table = 'themes_setting_option_translations';

    protected $fillable = ['name', 'explanation'];
}