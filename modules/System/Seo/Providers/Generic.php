<?php

namespace Modules\System\Seo\Providers;

use Modules\System\Seo\MetaTagProvider;
use Modules\System\Seo\SeoEntity;

class Generic extends MetaTagProvider
{

    protected function renderTitle($key, $value)
    {
        return "<title>$value</title>";
    }

    protected function handle(SeoEntity $seo)
    {
        $this->addProperty('title', $seo->getSeoTitle());
        $this->addProperty('description', $seo->getSeoDescription());
        $this->addProperty('keywords', $seo->getSeoKeywords());
    }
}
