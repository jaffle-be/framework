<?php namespace App\Theme;

use App\System\Scopes\ModelAccountResource;
use Illuminate\Database\Eloquent\Model;

class ThemeSettingValue extends Model
{
    use ModelAccountResource;

    protected $table = 'themes_setting_values';

    protected $fillable = ['key_id', 'account_id', 'option_id', 'value'];

    public function option()
    {
        return $this->belongsTo('App\Theme\ThemeSettingOption', 'option_id');
    }

    public function setting()
    {
        return $this->belongsTo('App\Theme\ThemeSetting', 'key_id');
    }

}