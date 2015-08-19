<?php namespace App\Theme;

use Jaffle\Tools\Translatable;
use Illuminate\Database\Eloquent\Model;

class ThemeSettingOption extends Model
{
    use translatable;

    protected $table = 'themes_setting_options';

    protected $translatedAttributes = ['name', 'explanation'];

    protected $translationForeignKey = 'option_id';

    protected $fillable = ['key_id', 'value', 'name', 'explanation'];

}