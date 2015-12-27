<?php

namespace Modules\Theme;

use Exception;
use Illuminate\Database\Eloquent\Collection;

trait MigrateThemeSettings
{
    /**
     * @var Collection
     */
    protected static $types = false;

    protected function settings(Theme $theme)
    {
        foreach ($this->settings as $setting) {
            $type = $this->settingGetType($setting);

            $setting['type_id'] = $type->id;

            unset($setting['type']);

            $setting = $theme->settings()->create($setting);

            $method = 'settingsHandle'.ucfirst($type->name);

            if (method_exists($this, $method)) {
                call_user_func([$this, $method], $setting);
            }
        }
    }

    protected function settingKeys()
    {
        return array_pluck($this->settings, 'key');
    }

    protected function settingsHandleSelect(ThemeSetting $setting)
    {
        $options = $this->options[$setting->key];

        foreach ($options as $option) {
            $setting->options()->create($option);
        }

        if (isset($this->defaults[$setting->key])) {
            $option = $setting->options()->where('value', $this->defaults[$setting->key])->first();

            $setting->defaults()->create(['option_id' => $option->id]);
        }
    }

    protected function settingsHandleString(ThemeSetting $setting)
    {
        $this->settingJsonHandle($setting);
    }

    protected function settingsHandleText(ThemeSetting $setting)
    {
        $this->settingJsonHandle($setting);
    }

    protected function settingGetType(array $setting)
    {
        if (!static::$types) {
            static::$types = ThemeSettingType::all()->keyBy('name');
        }

        if (!static::$types->has($setting['type'])) {
            throw new Exception('Invalid setting type provided');
        }

        return static::$types->get($setting['type']);
    }

    protected function settingJsonHandle(ThemeSetting $setting)
    {
        if (isset($this->defaults[$setting->key])) {
            $setting->defaults()->create(['value' => json_encode($this->defaults[$setting->key])]);
        }
    }
}
