<?php namespace App\System\Seo\Providers;

use App\System\Seo\MetaTagProvider;
use App\System\Seo\SeoEntity;

class Google extends MetaTagProvider
{

    protected function tag($key, $value)
    {
        return '<meta itemprop="' . strip_tags($key) . '" content="' . strip_tags($value) . '" />';
    }

    protected function handle(SeoEntity $seo)
    {
        $type = $seo->getSeoTypeGoogle();
        $this->addProperty('type', $type);

        if ($type == 'article') {
            $this->addProperty('datePublished', $seo->publish_at->format(DATE_ATOM));
            $this->addProperty('dateModified', $seo->updated_at->format(DATE_ATOM));
            $this->addProperty('publisher', 'digiredo.be');
            $this->addProperty('author', $seo->getSeoAuthor());
        }

        if($image = $seo->getSeoImage())
        {
            $this->addProperty('image', asset($image->path));
        }
    }

}