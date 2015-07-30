<?php namespace App\Theme;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    use translatable;

    protected $table = 'themes_setting_keys';

    protected $translatedAttributes = ['name', 'explanation'];

    protected $translationForeignKey = 'key_id';

    protected $fillable = ['theme_id', 'key', 'name', 'explanation'];

    public function options()
    {
        return $this->hasMany('App\Theme\ThemeSettingOption', 'key_id');
    }

    public function value()
    {
        return $this->hasOne('App\Theme\ThemeSettingValue', 'key_id');
    }

    public function newCollection(array $items = [])
    {
        $collection = new Collection($items);

        return $collection->keyBy('key');
    }

    public function defaults()
    {
        return $this->hasOne('App\Theme\ThemeSettingDefault', 'key_id');
    }

}