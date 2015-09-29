<?php namespace App\System\Sluggable;

trait Sluggable
{

    public function getRouteKeyName()
    {
        if (!starts_with(app('request')->getRequestUri(), ['/admin', '/api'])) {

            return 'slug';
        }

        return $this->getKeyName();
    }

}