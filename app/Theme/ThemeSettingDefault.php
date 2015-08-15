<?php namespace App\Theme;

use Illuminate\Database\Eloquent\Model;

class ThemeSettingDefault extends Model
{

    protected $table = 'themes_setting_defaults';

    protected $fillable = ['key_id', 'option_id', 'value'];

}