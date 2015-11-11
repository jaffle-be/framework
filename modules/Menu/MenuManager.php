<?php namespace Modules\Menu;

/**
 * Class MenuManager
 *
 * @package Modules\Menu
 */
class MenuManager
{

    /**
     * @var bool
     */
    protected $hasBeenLoaded = false;

    /**
     * @var array
     */
    protected $supports = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $loaded = [];

    /**
     * @var Engine\Engine
     */
    protected $engine;

    /**
     * @var MenuRepositoryInterface
     */
    protected $repository;

    /**
     * @param MenuRepositoryInterface $repository
     */
    public function __construct(MenuRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    function __call($name, $arguments)
    {
        return call_user_func_array([$this->repository, $name], $arguments);
    }

    /**
     * @param       $menu
     * @param array $options
     */
    public function register($menu, array $options = array())
    {
        $this->supports[] = $menu;
        $this->options[$menu] = $options;
    }

    /**
     * @param $menu
     *
     * @return mixed
     */
    public function get($menu)
    {
        //by the time the first menu is rendered, we should know all supported menu's for the current theme.
        if (!$this->hasBeenLoaded) {
            $this->load();
        }

        //if the menu is supported by the current theme, we'll render it.
        if (in_array($menu, $this->supports)) {
            return $this->loaded[$menu];
        }
    }

    public function crumbs($menu)
    {
        $menu = $this->get($menu);

        //find the active url

        //return home, followed by all the parents, followed by the current page
        return [];
    }

    protected function load()
    {
        //retrieve all menus from db
        $menus = $this->repository->getMenus();

        foreach($menus as $menu)
        {
            $this->loaded[$menu->name] = $menu;
        }

        //set loaded status
        $this->hasBeenLoaded = true;
    }

    protected function menu($menu)
    {
        return isset($this->loaded[$menu]) ? $this->loaded[$menu] : false;
    }
}