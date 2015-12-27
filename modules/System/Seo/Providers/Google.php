<?php

namespace Modules\System\Seo\Providers;

use Modules\System\Seo\MetaTagProvider;
use Modules\System\Seo\SeoEntity;

class Google extends MetaTagProvider
{
    protected function tag($key, $value)
    {
        return '<meta itemprop="'.strip_tags($key).'" content="'.strip_tags($value).'">';
    }

    protected function handle(SeoEntity $seo)
    {
        $type = $seo->getSeoTypeGoogle();
        $this->addProperty('type', $type);
        $this->addProperty('title', $seo->getSeoTitle());
        $this->addProperty('description', $seo->getSeoDescription());

        if ($type == 'article') {
            if ($seo->publish_at) {
                $this->addProperty('datePublished', $seo->publish_at->format(DATE_ATOM));
            }

            $this->addProperty('dateModified', $seo->updated_at->format(DATE_ATOM));
            $this->addProperty('publisher', 'digiredo.be');
            if ($seo->getSeoAuthor()) {
                $this->addProperty('author', $seo->getSeoAuthor());
            }
        }

        if ($image = $seo->getSeoImage()) {
            $this->addProperty('image', asset($image->path));
        }
    }

    /**
     *
     */
    protected function nameForTypeSpecificProperty($type, $key)
    {
        return $key;
    }
}
