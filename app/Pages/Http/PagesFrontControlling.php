<?php namespace App\Pages\Http;

use App\Pages\PageRepositoryInterface;
use App\Pages\PageTranslation;

trait PagesFrontControlling
{

    public function renderPageDetail(PageTranslation $page, PageRepositoryInterface $pages)
    {
        $page = $page->page;

        $page->load($pages->relations());

        $this->seo->setEntity($page);

        return $this->theme->render('pages.show', ['page' => $page]);
    }
}