<?php

namespace Modules\System\Sluggable;

/**
 * Interface OwnsSlug
 * @package Modules\System\Sluggable
 */
interface OwnsSlug
{
    public function slug();

    public function sluggify();

    public function save();
}
