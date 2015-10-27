<?php namespace Modules\Theme;

use Modules\System\Translatable\TranslationModel;

class ThemeSettingValueTranslation extends TranslationModel
{

    protected $table = 'themes_setting_value_translations';

    protected $fillable = ['string', 'text'];

}