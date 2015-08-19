<?php namespace App\Theme;

use App\System\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    use Translatable;

    protected $table = 'themes_setting_keys';

    protected $translatedAttributes = ['name', 'explanation'];

    protected $translationForeignKey = 'key_id';

    protected $fillable = ['theme_id', 'type_id', 'key', 'name', 'explanation'];

    protected $casts = [
        'boolean' => 'boolean'
    ];

    public function options()
    {
        return $this->hasMany('App\Theme\ThemeSettingOption', 'key_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Theme\ThemeSettingType', 'type_id');
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

    /**
     * Currently only used in the angular part, to return them through an /api/admin call
     *
     * @return array
     */
    public function toArray()
    {
        $result = parent::toArray();

        switch($this->type->name)
        {
            case 'boolean':
                $result['value'] = (bool) $result['value'];
                break;

            case 'string':
                break;

            case 'text':
                break;

            case 'select':
                break;

            case 'numeric':
                break;
        }

        return $result;
    }

    /**
     * Used when actually getting the value to decide what to do for the given setting.
     *
     * @return bool|mixed
     */
    public function getValue()
    {
        if ($this->type->name == 'boolean') {
            return $this->value ? true : false;
        }

        if ($this->type->name == 'string' || $this->type->name == 'text') {
            if ($this->value) {
                return $this->value->{$this->type->name};
            }

            return $this->key;
        }

        if ($this->type->name == 'select') {
            if ($this->value->option) {
                return $this->value->option->value;
            }

            return $this->value->value;
        }

        if ($this->type->name == 'numeric') {
            if($this->value)
            {
                return $this->value->value;
            }
        }
    }

}