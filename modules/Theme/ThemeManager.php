<?php

namespace Modules\Theme;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Factory;

/**
 * Class ThemeManager
 * @package Modules\Theme
 */
class ThemeManager
{
    protected $view;

    protected $events;

    protected $selector;

    protected $theme;

    protected $current;

    protected $repository;

    /**
     * We store the supported themes here once they are fetched.
     *
     * @var Collection
     */
    protected $supported;

    /**
     * @param Factory $view
     * @param ThemeRepositoryInterface $repository
     */
    public function __construct(Factory $view, ThemeRepositoryInterface $repository)
    {
        $this->view = $view;
        $this->repository = $repository;
    }

    public function boot()
    {
        if (! config('system.installed')) {
            return;
        }

        $selected = $this->repository->current();

        if ($selected) {
            $this->current = $selected;

            $this->setupNamespace();
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    public function email()
    {
        $theme = $this->current();

        if (! $theme) {
            throw new Exception('Need a theme set to be able to send emails');
        }

        return ucfirst(strtolower($theme->name)).'::'.strtolower($theme->name).'-email';
    }

    /**
     * @return null
     */
    public function name()
    {
        return $this->current() ? $this->current()->name : null;
    }

    /**
     * @return bool
     */
    public function current()
    {
        return $this->current ? $this->current->theme : false;
    }

    public function selection()
    {
        return $this->current;
    }

    /**
     * @param $key
     * @throws Exception
     */
    public function setting($key)
    {
        if (! $theme = $this->current()) {
            return;
        }

        if (! $setting = $theme->settings->get($key)) {
            throw new Exception(sprintf('Unknown setting requested: %s', $key));
        }

        return $setting->getValue();
    }

    /**
     * @param $view
     * @param array $data
     * @return \Illuminate\Contracts\View\View
     */
    public function render($view, array $data = [])
    {
        $name = $this->name();

        return $this->view->make($name.'::'.$view, $data);
    }

    protected function setupNamespace()
    {
        $name = $this->name();

        $this->view->addNamespace('theme.'.$name, config('theme.path').'/'.$name.'/views');
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repository, $name], $arguments);
    }
}
