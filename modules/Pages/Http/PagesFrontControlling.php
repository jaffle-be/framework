<?php

namespace Modules\Pages\Http;

use Modules\Pages\PageRepositoryInterface;
use Modules\Pages\PageTranslation;

/**
 * Class PagesFrontControlling
 * @package Modules\Pages\Http
 */
trait PagesFrontControlling
{
    /**
     * @param PageTranslation $page
     * @param PageRepositoryInterface $pages
     * @return mixed
     */
    public function renderPageDetail(PageTranslation $page, PageRepositoryInterface $pages)
    {
        $page = $page->page;

        $page->load($pages->relations());

        $this->seo->setEntity($page);

        return $this->theme->render('pages.show', ['page' => $page]);
    }
}
