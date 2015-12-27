<?php

namespace Modules\Theme;

use Illuminate\Contracts\Cache\Repository;

/**
 * Class CachedThemeRepository
 * @package Modules\Theme
 */
class CachedThemeRepository implements ThemeRepositoryInterface
{
    protected $theme;

    /**
     * @var Repository
     */
    protected $cache;

    /**
     * @param ThemeRepository $theme
     * @param Repository $cache
     */
    public function __construct(ThemeRepository $theme, Repository $cache)
    {
        $this->theme = $theme;
        $this->cache = $cache;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->cache->sear('theme', function () {

            return $this->theme->current();
        });
    }

    /**
     * @return mixed
     */
    public function supported()
    {
        return $this->theme->supported();
    }

    /**
     * @param $theme
     * @return mixed
     */
    public function activate($theme)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $result = call_user_func_array([$this->theme, $name], $arguments);

        $this->cache->forget('theme');

        return $result;
    }
}
