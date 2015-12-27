<?php

namespace Modules\Pages;

class PageRepository implements PageRepositoryInterface
{
    protected $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->page, $name], $arguments);
    }

    public function allowFallback()
    {
        $this->page->useTranslationFallback = true;
    }

    /**
     * @return []
     */
    public function relations()
    {
        return ['user', 'translations'];
    }
}
