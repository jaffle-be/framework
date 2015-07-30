<?php namespace App\Theme;

use Jaffle\Tools\TranslationModel;

class ThemeSettingTranslation extends TranslationModel
{

    protected $table = 'themes_setting_key_translations';

    protected $fillable = ['name', 'explanation'];

}