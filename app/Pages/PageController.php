<?php namespace App\Pages;

use App\Pages\Http\PagesFrontControlling;
use App\System\Http\FrontController;

class PageController extends FrontController
{
    use PagesFrontControlling;

    public function show(Page $page, PageRepositoryInterface $pages)
    {
        return $this->renderPageDetail($page, $pages);
    }

}