<?php

namespace Modules\System\Seo\Providers;

use Modules\System\Seo\MetaTagProvider;
use Modules\System\Seo\SeoEntity;

/**
 * Class Generic
 * @package Modules\System\Seo\Providers
 */
class Generic extends MetaTagProvider
{
    /**
     * @param $key
     * @param $value
     * @return string
     */
    protected function renderTitle($key, $value)
    {
        return "<title>$value</title>";
    }

    /**
     * @param SeoEntity $seo
     */
    protected function handle(SeoEntity $seo)
    {
        $this->addProperty('title', $seo->getSeoTitle());
        $this->addProperty('description', $seo->getSeoDescription());
        $this->addProperty('keywords', $seo->getSeoKeywords());
    }
}
