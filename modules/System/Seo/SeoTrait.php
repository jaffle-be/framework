<?php

namespace Modules\System\Seo;

use Modules\Media\StoresMedia;
use Modules\System\Locale;
use Modules\System\Presenter\PresentableEntity;
use Modules\Users\User;

/**
 * Class SeoTrait
 * @package Modules\System\Seo
 */
trait SeoTrait
{
    public function seo()
    {
        return $this->morphMany('Modules\System\Seo\SeoProperty', 'owner');
    }

    /**
     * @param $field
     * @return bool
     */
    protected function getSeoCustomisation($field)
    {
        static $locale;

        if (! $locale) {
            $locale = app()->getLocale();

            $locale = Locale::whereSlug($locale)->first();
        }

        if ($this->seo) {
            $localised = $this->seo->first(function ($key, $item) use ($locale) {
                return $item->locale_id == $locale->id;
            });

            if ($localised) {
                return $localised->$field;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function getSeoTitle()
    {
        if ($seo = $this->getSeoCustomisation('title')) {
            return $seo;
        }

        if ($this instanceof PresentableEntity) {
            return $this->present()->title;
        }

        return $this->title;
    }

    /**
     * @return bool
     */
    public function getSeoDescription()
    {
        if ($seo = $this->getSeoCustomisation('description')) {
            return $seo;
        }

        //use customised seo field if provided.
        $hasCustomSeoAttribute = property_exists($this, 'seo') && is_array($this->seo) && isset($this->seo['extract']);

        //if we have a presentable we'll get the content through that.
        //so it'll automatically use the same rules
        //as we use on our website.
        if ($this instanceof PresentableEntity) {
            if ($hasCustomSeoAttribute) {
                return $this->present()->{$this->seo['extract']};
            }

            return $this->present()->extract;
        }

        if ($hasCustomSeoAttribute) {
            return $this->{$this->seo['extract']};
        }

        return $this->extract;
    }

    /**
     * @return bool
     */
    public function getSeoKeywords()
    {
        if ($seo = $this->getSeoCustomisation('keywords')) {
            return $seo;
        }

        //we could use most significant terms? search engines must use some sort of same implementation.
        //therefor our keywords to our documents will always be scored 'perfect' in their algorithms, should boost us.
        //we could add a preview in our admin, that shows suggestions of what people look for when
        //they make use of some of the terms in our article
        //if we could show that in our article.
        //a journalist, would be able to write content and immediately tweak it to better match those search terms.

        //we could use the tags used if it's a taggable thing.
    }

    public function getSeoImage()
    {
        if ($this instanceof StoresMedia) {
            $image = $this->images;

            if ($this->mediaStoresMultiple()) {
                $image = $this->images->first();
            }

            return $image;
        }
    }

    public function getSeoUrl()
    {
        return app('url')->current();
    }

    /**
     * @return string
     */
    public function getSeoTypeFacebook()
    {
        return 'article';
    }

    /**
     * @return string
     */
    public function getSeoTypeGoogle()
    {
        return 'article';
    }

    /**
     * @return string
     */
    public function getSeoTypeTwitter()
    {
        return 'summary_image_large';
    }

    /**
     * @return mixed
     */
    public function getSeoAuthor()
    {
        if ($this->user instanceof User) {
            return $this->user->fullName;
        }
    }
}
