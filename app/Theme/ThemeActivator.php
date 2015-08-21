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

}