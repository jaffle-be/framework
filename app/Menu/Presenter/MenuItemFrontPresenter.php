<?php namespace App\Menu\Presenter;

use App\System\Presenter\BasePresenter;

class MenuItemFrontPresenter extends BasePresenter
{

    public function url()
    {
        if ($this->entity->page) {
            return $this->pageUrl();
        }

        return $this->entity->url;
    }

    public function shouldPresent()
    {
        //item should not relate to a page,
        //or the page should actually be there.
        //it won't be there if the page is not published for instance.
        return !$this->entity->page_id || ($this->entity->page_id && $this->entity->page->translate());
    }

    protected function pageUrl()
    {
        $page = $this->entity->page;

        $translation = $page->translate(null, true);

        return '/' . $translation->slug->uri;
    }

}