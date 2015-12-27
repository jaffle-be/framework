<?php

namespace Modules\Theme;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Translatable\Translatable;

class ThemeSetting extends Model
{
    use Translatable;

    protected $table = 'themes_setting_keys';

    protected $translatedAttributes = ['name', 'explanation'];

    protected $translationForeignKey = 'key_id';

    protected $fillable = ['theme_id', 'type_id', 'key', 'name', 'explanation'];

    protected $casts = [
        'boolean' => 'boolean',
        'key' => 'string',
    ];

    public function options()
    {
        return $this->hasMany('Modules\Theme\ThemeSettingOption', 'key_id');
    }

    public function type()
    {
        return $this->belongsTo('Modules\Theme\ThemeSettingType', 'type_id');
    }

    public function value()
    {
        return $this->hasOne('Modules\Theme\ThemeSettingValue', 'key_id');
    }

    public function newCollection(array $items = [])
    {
        $collection = new ThemeSettingCollection($items);

        return $collection->keyBy('key');
    }

    public function defaults()
    {
        return $this->hasOne('Modules\Theme\ThemeSettingDefault', 'key_id');
    }

    /**
     * Currently only used in the angular part, to return them through an /api/admin call.
     *
     *
     */
    public function toArray()
    {
        $result = parent::toArray();

        switch ($this->type->name) {
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
     *
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
            if ($this->value) {
                return $this->value->value;
            }
        }
    }
}
