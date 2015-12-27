<?php

namespace Modules\Menu\Presenter;

use Modules\System\Presenter\BasePresenter;

class MenuItemFrontPresenter extends BasePresenter
{
    public function url()
    {
        if ($this->entity->page) {
            return $this->pageUrl();
        }

        if ($this->entity->route) {
            return store_route($this->entity->route->name);
        }

        return $this->entity->url;
    }

    protected function pageUrl()
    {
        $page = $this->entity->page;

        $translation = $page->translate(null, true);

        return '/'.$translation->slug->uri;
    }

    public function shouldPresent()
    {
        //item should not relate to a page,
        //or the page should actually be there.
        //it won't be there if the page is not published for instance.
        return $this->manualItem() || $this->validPage() || $this->validRoute();
    }

    /**
     *
     */
    protected function manualItem()
    {
        return ! $this->entity->page_id && ! $this->entity->module_route_id;
    }

    /**
     *
     */
    protected function validPage()
    {
        $modules = app('Modules\Account\AccountManager')->account()->modules;

        $activated = $modules->first(function ($key, $item) {
            return $item->name == 'pages';
        });

        return $activated && $this->entity->page_id && $this->entity->page->translate();
    }

    protected function validRoute()
    {
        $modules = app('Modules\Account\AccountManager')->account()->modules;

        return $this->entity->route && $modules->contains($this->entity->route->module->id);
    }
}
