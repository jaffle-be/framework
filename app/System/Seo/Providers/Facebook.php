<?php namespace App\System\Seo\Providers;

use App\System\Seo\MetaTagProvider;
use App\System\Seo\SeoEntity;

class Facebook extends MetaTagProvider
{
    protected $prefix = 'og:';

    protected function tag($key, $value)
    {
        if(!property_exists($this, 'prefix'))
        {
            throw new \Exception('Need to define the prefix property for generating meta tags');
        }

        return '<meta property="' . $this->prefix . strip_tags($key) . '" content="' . strip_tags($value) . '">';
    }

    public function renderAppId($key, $value)
    {
        return sprintf('<meta property="fb:app_id" content="%s">', $value);
    }

    protected function handle(SeoEntity $seo)
    {
        //add the facebook app id to enable insights.
        $this->addProperty('app_id', $this->config['app_id']);
        $type = $seo->getSeoTypeFacebook();
        $this->addProperty('type', $type);
        $this->addProperty('title', $seo->getSeoTitle());
        $this->addProperty('description', $seo->getSeoDescription());

        if($type == 'article')
        {
            if($seo->publish_at)
            {
                $this->addProperty('article:published_time', $seo->publish_at->format(DATE_ATOM));
            }

            $this->addProperty('article:modified_time', $seo->updated_at->format(DATE_ATOM));
            $this->addProperty('article:author', 'digiredo.be');
        }

        if($image = $seo->getSeoImage())
        {
            $this->addProperty('image', asset($image->path));
        }

    }

}