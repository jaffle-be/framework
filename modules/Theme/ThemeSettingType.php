<?php namespace Modules\Theme;

use Illuminate\Database\Eloquent\Model;

class ThemeSettingType extends Model
{

    protected $table = 'themes_setting_key_types';

    protected $fillable = ['name'];

    public $timestamps = false;

}