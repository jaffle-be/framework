<?php namespace App\System\Seo\Providers;

use App\System\Seo\MetaTagProvider;
use App\System\Seo\SeoEntity;

class Twitter extends MetaTagProvider
{

    protected $prefix = 'twitter:';

    protected function handle(SeoEntity $seo)
    {
        $this->addProperty('title', substr($seo->getSeoTitle(), 0, 70));
        $this->addProperty('description', substr($seo->getSeoDescription(), 0, 200));

        if($image = $seo->getSeoImage())
        {
            $this->addProperty('image', asset($image->path));
        }
    }

}