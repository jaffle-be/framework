<?php namespace App\Theme;

use App\Account\AccountManager;

/**
 * Class ThemeActivator
 *
 * @package App\Theme
 */
class ThemeActivator
{

    /**
     * @var Theme
     */
    protected $theme;

    /**
     * @var \App\Account\Account|bool
     */
    protected $account;

    /**
     * @var ThemeSelection
     */
    protected $selector;

    /**
     * @param Theme          $theme
     * @param AccountManager $manager
     * @param ThemeSelection $selection
     */
    public function __construct(Theme $theme, AccountManager $manager, ThemeSelection $selection)
    {
        $this->theme = $theme;
        $this->account = $manager->account();
        $this->selector = $selection;
    }

    /**
     * @param $theme
     *
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
     * @param Theme $theme
     *
     * @return ThemeSelection
     */
    protected function createSelection(Theme $theme)
    {
        if($this->account)
        {
            $selector = $this->selector->create([
                'theme_id'   => $theme->id,
                'account_id' => $this->account->getKey(),
                'active'     => true
            ]);

            $this->addDefaults($theme, $selector);

            return $selector;
        }
    }

    /**
     * @param Theme $theme
     */
    protected function addDefaults(Theme $theme, ThemeSelection $selection)
    {
        foreach($theme->settings as $setting)
        {
            $default = $setting->defaults;

            if($default)
            {
                $default = $default->toArray();

                $default = array_except($default, ['id', 'created_at', 'updated_at']);

                $payload = array_merge(['account_id' => $this->account->id, 'selection_id' => $selection->id], $default);

                $setting->value()->create($payload);
            }
        }
    }
}