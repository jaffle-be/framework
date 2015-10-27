<?php namespace Modules\System\Seo\Providers;

use Modules\System\Seo\MetaTagProvider;
use Modules\System\Seo\SeoEntity;

class Facebook extends MetaTagProvider
{

    protected $prefix = 'og:';

    protected function tag($key, $value)
    {
        if (!property_exists($this, 'prefix')) {
            throw new \Exception('Need to define the prefix property for generating meta tags');
        }

        if(str_contains($key, ':'))
        {
            return '<meta property="' . strip_tags($key) . '" content="' . strip_tags($value) . '">';
        }
        else{
            return '<meta property="' . $this->prefix . strip_tags($key) . '" content="' . strip_tags($value) . '">';
        }

    }

    public function renderAppId($key, $value)
    {
        return sprintf('<meta property="fb:app_id" content="%s">', $value);
    }

    protected function handle(SeoEntity $seo)
    {
        //add the facebook app id to enable insights.
        $type = $seo->getSeoTypeFacebook();
        $this->addProperty('type', $type);
        $this->addProperty('title', $seo->getSeoTitle());
        $this->addProperty('description', $seo->getSeoDescription());

        if ($type == 'article') {
            if ($seo->publish_at) {
                $this->addProperty('article:published_time', $seo->publish_at->format(DATE_ATOM));
            }

            $this->addProperty('article:modified_time', $seo->updated_at->format(DATE_ATOM));
        }

        if ($image = $seo->getSeoImage()) {
            $this->addProperty('image', asset($image->path));
        }
    }

}