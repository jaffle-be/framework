<?php namespace App\Menu\Presenter;

use App\System\Presenter\BasePresenter;

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

    public function shouldPresent()
    {
        //item should not relate to a page,
        //or the page should actually be there.
        //it won't be there if the page is not published for instance.
        return $this->manualItem() || $this->validPage() || $this->validRoute();
    }

    protected function pageUrl()
    {
        $page = $this->entity->page;

        $translation = $page->translate(null, true);

        return '/' . $translation->slug->uri;
    }

    protected function validRoute()
    {
        $modules = app('App\Account\AccountManager')->account()->modules;

        return $modules->contains($this->entity->route->module->id);
    }

    /**
     * @return bool
     */
    protected function validPage()
    {
        $modules = app('App\Account\AccountManager')->account()->modules;

        $activated = $modules->first(function($key, $item){
            return $item->name == 'pages';
        });

        return $activated && $this->entity->page_id && $this->entity->page->translate();
    }

    /**
     * @return bool
     */
    protected function manualItem()
    {
        return !$this->entity->page_id && !$this->entity->module_route_id;
    }

}