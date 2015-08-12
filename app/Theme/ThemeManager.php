<?php

namespace App\Theme;

use App\Account\AccountManager;
use Exception;
use Illuminate\Database\Eloquent\Collection;
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
     *
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

        if(!config('system.installed'))
        {
            return;
        }

        $selected = $this->selector
            ->where('active', true)
            ->first();

        //we default to the unify theme

        if (!$selected) {
            $selected = $this->setupDefaultTheme($manager);
        }

        if($selected)
        {
            $this->current = $selected;

            $this->setupNamespace();
        }
    }

    public function name()
    {
        return $this->current() ? $this->current()->name : null;
    }

    public function current()
    {
        return $this->current ? $this->current->theme : false;
    }

    public function selection()
    {
        return $this->current;
    }

    public function setting($key)
    {
        $theme = $this->current();

        if(!$theme)
        {
            return;
        }

        $setting = $theme->settings->get($key);

        if(!$setting)
        {
            throw new Exception(sprintf('Unknown setting requested: %s', $key));
        }

        switch($setting->getType())
        {
            case 'boolean':
                return $setting->value ? true : false;
                break;
            case 'string':
                if($setting->value)
                {
                    return $setting->value->string;
                }
                return $key;
                break;
            case 'text':
                if($setting->value)
                {
                    return $setting->value->text;
                }

                return $key;

                break;
            case 'select':
                if($setting->value->option)
                {
                    return $setting->value->option->value;
                }
                return $setting->value->value;

                break;
        }

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
        if (!$this->supported) {
            $this->supported = $this->theme->orderBy('name')->get();
        }

        if ($theme) {
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

        return $this->activate($default->id, $account);
    }

}