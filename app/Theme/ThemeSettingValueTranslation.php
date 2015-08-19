<?php namespace App\Theme;

use App\System\Translatable\TranslationModel;

class ThemeSettingValueTranslation extends TranslationModel
{

    protected $table = 'themes_setting_value_translations';

    protected $fillable = ['string', 'text'];

}