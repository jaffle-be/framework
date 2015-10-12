<?php namespace App\System\Seo\Providers;

use App\System\Seo\MetaTagProvider;
use App\System\Seo\SeoEntity;

class Twitter extends MetaTagProvider
{

    protected $prefix = 'twitter:';

    protected function handle(SeoEntity $seo)
    {
        $this->addProperty('title', $seo->getSeoTitle());
        $this->addProperty('description', $seo->getSeoDescription());

        if($image = $seo->getSeoImage())
        {
            $this->addProperty('image', asset($image->path));
        }
    }

}