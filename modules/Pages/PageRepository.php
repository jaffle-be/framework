<?php

namespace Modules\Pages;

/**
 * Class PageRepository
 * @package Modules\Pages
 */
class PageRepository implements PageRepositoryInterface
{
    protected $page;

    /**
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->page, $name], $arguments);
    }

    public function allowFallback()
    {
        $this->page->useTranslationFallback = true;
    }

    /**
     *
     */
    public function relations()
    {
        return ['user', 'translations'];
    }
}
