<?php namespace App\System\Sluggable;

trait Sluggable
{

    public function setSlugAttribute($value)
    {
        $this->attributes[$this->currentSlug()] = $value;
    }

    protected function currentSlug()
    {
        if (!starts_with(app('request')->getRequestUri(), ['/admin', '/api'])) {
            return 'slug_' . app()->getLocale();
        }

        return $this->getKeyName();
    }

    public function getRouteKeyName()
    {
        return $this->currentSlug();
    }

}