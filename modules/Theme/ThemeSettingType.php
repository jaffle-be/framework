<?php namespace Modules\Theme;

use Illuminate\Database\Eloquent\Model;

class ThemeSettingType extends Model
{

    public $timestamps = false;

    protected $table = 'themes_setting_key_types';

    protected $fillable = ['name'];

}