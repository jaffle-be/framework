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

    protected $fillable = ['theme_id', 'boolean', 'string', 'text', 'key', 'name', 'explanation'];

    protected $casts = [
        'boolean' => 'boolean'
    ];

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

    public function toArray()
    {
        $result = parent::toArray();

        if($this->boolean)
        {
            $result['value'] = (bool) $result['value'];
        }

        return $result;
    }

    public function getType()
    {
        $types = ['boolean', 'string', 'text'];

        foreach($types as $type)
        {
            if(isset($this->attributes[$type]) && $this->attributes[$type])
            {
                return $type;
            }
        }

        return 'select';
    }

}