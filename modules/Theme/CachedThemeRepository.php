<?php namespace Modules\Theme;

use Illuminate\Contracts\Cache\Repository;

class CachedThemeRepository implements ThemeRepositoryInterface
{

    protected $theme;

    /**
     * @var Repository
     */
    protected $cache;

    public function __construct(ThemeRepository $theme, Repository $cache)
    {
        $this->theme = $theme;
        $this->cache = $cache;
    }

    public function current()
    {
        return $this->cache->sear('theme', function () {

            return $this->theme->current();
        });
    }

    public function supported()
    {
        return $this->theme->supported();
    }

    public function activate($theme)
    {
        return $this->__call(__FUNCTION__, func_get_args());
    }

    function __call($name, $arguments)
    {
        $result = call_user_func_array([$this->theme, $name], $arguments);

        $this->cache->forget('theme');

        return $result;
    }

}