<?php namespace App\Theme;

use App\System\Translatable\TranslationModel;

class ThemeSettingTranslation extends TranslationModel
{

    protected $table = 'themes_setting_key_translations';

    protected $fillable = ['name', 'explanation'];

}