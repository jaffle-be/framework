<?php namespace App\System\Sluggable;

use Cviebrock\EloquentSluggable\SluggableTrait;

trait Sluggable
{
    use SluggableTrait;

    public function getRouteKeyName()
    {
        if (!starts_with(app('request')->getRequestUri(), ['/admin', '/api'])) {

            return 'slug';
        }

        return $this->getKeyName();
    }

}