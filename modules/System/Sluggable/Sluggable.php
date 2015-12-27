<?php

namespace Modules\System\Sluggable;

use Cviebrock\EloquentSluggable\SluggableTrait;

trait Sluggable
{
    use SluggableTrait;

    public function getRouteKeyName()
    {
        if (!starts_with(app('request')->getRequestUri(), ['/admin', '/api'])) {
            return isset($this->sluggable['save_to']) ? $this->sluggable['save_to'] : 'slug';
        }

        return $this->getKeyName();
    }
}
