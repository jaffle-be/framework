<?php namespace App\System\Seo\Providers;

use App\System\Seo\MetaTagProvider;
use App\System\Seo\SeoEntity;

class Generic extends MetaTagProvider
{

    protected function handle(SeoEntity $seo)
    {
        $this->addProperty('title', $seo->getSeoTitle());
        $this->addProperty('description', $seo->getSeoDescription());
        $this->addProperty('keywords', $seo->getSeoKeywords());
    }

}