<?php

namespace Modules\System\Sluggable;

use Cviebrock\EloquentSluggable\SluggableTrait;

/**
 * Class Sluggable
 * @package Modules\System\Sluggable
 */
trait Sluggable
{
    use SluggableTrait;

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        if (! starts_with(app('request')->getRequestUri(), ['/admin', '/api'])) {
            return isset($this->sluggable['save_to']) ? $this->sluggable['save_to'] : 'slug';
        }

        return $this->getKeyName();
    }
}
