<?php namespace App\Theme;

use Jaffle\Tools\TranslationModel;

class ThemeSettingValueTranslation extends TranslationModel
{

    protected $table = 'themes_setting_value_translations';

    protected $fillable = ['string', 'text'];

}