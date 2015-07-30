<?php

namespace App\Theme;

use App\Account\Account;
use App\Account\AccountManager;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Events\Dispatcher;
use Illuminate\View\Factory;

class ThemeManager
{

    protected $view;

    protected $events;

    protected $selector;

    protected $theme;

    protected $current;

    /**
     * We store the supported themes here once they are fetched.
     * @var Collection
     */
    protected $supported;

    public function __construct(Factory $view, ThemeSelection $selector, Theme $theme)
    {
        $this->view = $view;
        $this->selector = $selector;
        $this->theme = $theme;
    }

    public function boot(AccountManager $manager)
    {
        $account = $manager->account();

        $selected = $this->selector
            ->where('active', true)
            ->first();

        //we default to the unify theme
        if(!$selected)
        {
            $selected = $this->setupDefaultTheme($manager);
        }

        $this->current = $selected->theme;

        $this->setupNamespace();
    }

    public function name()
    {
        return $this->current ? $this->current->name : null;
    }

    public function current()
    {
        return $this->current;
    }

    public function setting($key)
    {
        $theme = $this->current();

        $value = $theme->settings->get($key)->value;

        if($value->option)
        {
            return $value->option->value;
        }

        return $value->value;
    }

    public function activate($theme, AccountManager $manager)
    {
        $activator = new ThemeActivator($this->theme, $manager, $this->selector);

        return $activator->activate($theme);
    }

    /**
     * @param null $theme
     *
     * @return Collection
     */
    public function supported($theme = null)
    {
        if(!$this->supported)
        {
            $this->supported = $this->theme->orderBy('name')->get();
        }

        if($theme)
        {
            return $this->supported->contains('name', $theme);
        }

        return $this->supported;
    }

    public function render($view, array $data = [])
    {
        $name = $this->name();

        return $this->view->make($name . '::' . $view, $data);
    }

    protected function setupNamespace()
    {
        $name = $this->name();

        $this->view->addNamespace('theme.' . $name, config('theme.path') . '/' . $name . '/views');
    }

    protected function setupDefaultTheme(AccountManager $account)
    {
        $themes = $this->supported();

        $default = config('theme.default');

        $default = array_first($themes, function($key, $theme) use ($default){
            return $theme->name == $default;
        });

        if(!$default)
        {
            throw new Exception('Invalid default theme provided');
        }

        return $this->activate($default->id, $account);
    }

}