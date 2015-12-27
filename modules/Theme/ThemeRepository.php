<?php

namespace Modules\Theme;

use Modules\Account\AccountManager;

class ThemeRepository implements ThemeRepositoryInterface
{

    protected $theme;

    protected $selector;

    protected $account;

    protected $supported;

    public function __construct(ThemeSelection $selector, Theme $theme, AccountManager $account)
    {
        $this->selector = $selector;

        $this->theme = $theme;

        $this->account = $account;
    }

    public function current()
    {
        $selected = $this->selection();

        //we default to the unify theme
        if (!$selected) {
            $selected = $this->setupDefaultTheme();
        }

        if ($selected) {
            $selected->load($this->relations());
        }

        return $selected;
    }

    /**
     * @return mixed
     */
    protected function selection()
    {
        $selected = $this->selector
            ->where('active', true)
            ->first();

        return $selected;
    }

    protected function setupDefaultTheme()
    {
        $themes = $this->supported();

        if (!$themes->count()) {
            return false;
        }

        $default = config('theme.default');

        $default = array_first($themes, function ($key, $theme) use ($default) {
            return $theme->name == $default;
        });

        if (!$default) {
            return false;
        }

        return $this->activate($default->id);
    }

    public function supported()
    {
        return $this->supported = $this->theme->orderBy('name')->get();
    }

    /**
     * @return ThemeSelection|bool
     */
    public function activate($theme)
    {
        $theme = $this->theme->find($theme);

        if ($theme) {
            $this->selector
                ->update(['active' => false]);

            $selection = $this->selector
                ->where('theme_id', $theme->id)
                ->first();

            if ($selection) {
                $selection->active = true;
                $selection->save();

                return $selection;
            }

            return $this->createSelection($theme);
        }

        return false;
    }

    /**
     * @return ThemeSelection
     */
    protected function createSelection(Theme $theme)
    {
        if ($this->account->account()) {
            $selector = $this->selector->create([
                'theme_id' => $theme->getKey(),
                'account_id' => $this->account->account()->getKey(),
                'active' => true,
            ]);

            $this->addDefaults($theme, $selector);

            return $selector;
        }
    }

    /**
     *
     */
    protected function addDefaults(Theme $theme, ThemeSelection $selection)
    {
        $account = $this->account->account()->getKey();

        $selection = $selection->getKey();

        foreach ($theme->settings as $setting) {
            $default = $setting->defaults;

            if ($default) {
                if ($setting->type->name == 'select') {
                    $this->setupSelectDefault($selection, $default, $account, $setting);
                } elseif (in_array($setting->type->name, ['string', 'text'])) {
                    $this->setupJsonDefault($selection, $default, $account, $setting);
                }
            }
        }
    }

    /**
     *
     */
    protected function setupSelectDefault($selection, ThemeSettingDefault $default, $account, ThemeSetting $setting)
    {
        $default = $default->toArray();

        $default = array_except($default, ['id', 'created_at', 'updated_at']);

        $payload = array_merge(['account_id' => $account, 'selection_id' => $selection], $default);

        $setting->value()->create($payload);
    }

    protected function setupJsonDefault($selection, ThemeSettingDefault $default, $account, ThemeSetting $setting)
    {
        $json = json_decode($default->value);

        $type = $setting->type->name;

        $setting->value()->create([
            'account_id' => $account,
            'selection_id' => $selection,
            'nl' => [$type => $json->nl],
            'en' => [$type => $json->en],
        ]);
    }

    /**
     * @return array
     */
    protected function relations()
    {
        return ['theme', 'theme.settings', 'theme.settings.value', 'theme.settings.value.translations', 'theme.settings.value.option', 'theme.settings.type', 'theme.settings.options', 'theme.settings.defaults'];
    }

    public function updateBoolean($setting, $checked)
    {
        $setting->value()->delete();

        if ($checked) {
            $setting->value()->create([
                'value' => true,
                'account_id' => $this->account->account()->id,
                'selection_id' => $this->selection()->id,
            ]);
        }
    }

    public function updateSelect($setting, $selected, ThemeSettingOption $option)
    {
        $option = $option->find($selected);

        $setting->value()->delete();

        $setting->value()->create([
            'option_id' => $option->id,
            'account_id' => $this->account->account()->id,
            'selection_id' => $this->selection()->id,
        ]);
    }

    public function updateString($setting, $input)
    {
        $value = $setting->value;

        if (!$value) {
            $input = array_merge(['account_id' => $this->account->account()->id, 'selection_id' => $this->selection()->id], $input);

            return $setting->value()->create($input);
        }

        $value->fill($input);

        $value->save();
    }

    public function updateNumeric($setting, $value)
    {
        //if no original
        if (!$setting->value) {
            $input = array_merge(['value' => $value], ['account_id' => $this->account->account()->id, 'selection_id' => $this->selection()->id]);

            return $setting->value()->create($input);
        }

        $value->value = $value;

        $value->save();
    }
}
