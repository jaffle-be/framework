<?php

namespace Modules\Theme;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ThemeSettingType
 * @package Modules\Theme
 */
class ThemeSettingType extends Model
{
    public $timestamps = false;

    protected $table = 'themes_setting_key_types';

    protected $fillable = ['name'];
}
