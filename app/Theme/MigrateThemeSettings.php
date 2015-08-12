<?php namespace App\Theme;

use Exception;

trait MigrateThemeSettings
{

    protected function settings(Theme $theme)
    {

        foreach ($this->settings as $setting) {

            $setting = $theme->settings()->create($setting);

            $type = $setting->getType();

            $method = 'settingsHandle' . ucfirst($type);

            call_user_func([$this, $method], $setting);
        }
    }

    protected function settingKeys()
    {
        return array_pluck($this->settings, 'key');
    }

    protected function settingsHandleBoolean(ThemeSetting $setting)
    {

    }

    protected function settingsHandleString(ThemeSetting $setting)
    {

    }

    protected function settingsHandleText(ThemeSetting $setting)
    {

    }

    protected function settingsHandleSelect(ThemeSetting $setting)
    {
        $options = $this->options[$setting->key];

        foreach ($options as $option) {
            $setting->options()->create($option);
        }

        if(isset($this->defaults[$setting->key]))
        {
            $option = $setting->options()->where('value', $this->defaults[$setting->key])->first();

            $setting->defaults()->create(['option_id' => $option->id]);
        }
    }

}