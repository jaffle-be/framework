<?php

namespace App\Theme;

use Illuminate\Config\Repository;
use Illuminate\Events\Dispatcher;
use Illuminate\View\Factory;

class Theme implements \App\Theme\Contracts\Theme
{

    protected $config;

    protected $view;

    protected $events;

    public function __construct(Repository $config, Factory $view, Dispatcher $events)
    {
        $this->config = $config;
        $this->view = $view;
        $this->events = $events;
    }

    public function name($name = null)
    {
        if (!empty($name)) {
            $this->config->set('theme.name', $name);

            $this->setupNamespace($name);
        }

        return $this->config->get('theme.name');
    }

    public function render($view, array $data = [])
    {
        $name = $this->name();

        return $this->view->make('theme.' . $name . '::' . $view, $data);
    }

    /**
     * Return an asset from a theme
     *
     * @param $asset
     * @return string
     */
    public function asset($asset)
    {
        $asset = config('theme.public_path') . '/' . $this->name() . '/assets/' . ltrim($asset, '/');

        return asset($asset);
    }


    protected function setupNamespace($name)
    {
        $this->view->addNamespace('theme.unify', config('theme.path') . '/' . $name . '/views');
    }

}