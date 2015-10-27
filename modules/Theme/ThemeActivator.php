<?php namespace Modules\Theme;

use Modules\Account\AccountManager;

/**
 * Class ThemeActivator
 *
 * @package Modules\Theme
 */
class ThemeActivator
{

    /**
     * @var Theme
     */
    protected $theme;

    /**
     * @var \Modules\Account\Account|bool
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