<?php

namespace Modules\System\Uri;

use Modules\System\Sluggable\OwnsSlug;

/**
 * Class Creator
 * @package Modules\System\Uri
 */
class Creator
{
    /**
     * @param $object
     */
    public function handle($object)
    {
        if ($object instanceof OwnsSlug) {
            $object->sluggify();
            $object->save();
        }
    }
}
