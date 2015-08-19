<?php namespace App\Theme;

use App\System\Scopes\ModelAccountResource;
use Jaffle\Tools\Translatable;
use Illuminate\Database\Eloquent\Model;

class ThemeSettingValue extends Model
{
    use ModelAccountResource;
    use Translatable;

    protected $table = 'themes_setting_values';

    protected $fillable = ['selection_id', 'key_id', 'account_id', 'option_id', 'value', 'string', 'text'];

    protected $translatedAttributes = ['string', 'text'];

    protected $translationForeignKey = 'value_id';

    public function selection()
    {
        return $this->belongsTo('App\Theme\ThemeSelection', 'selection_id');
    }

    public function option()
    {
        return $this->belongsTo('App\Theme\ThemeSettingOption', 'option_id');
    }

    public function setting()
    {
        return $this->belongsTo('App\Theme\ThemeSetting', 'key_id');
    }

}