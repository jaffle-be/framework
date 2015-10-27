<?php namespace Modules\System\Uri;

use Modules\System\Sluggable\OwnsSlug;

class Creator
{

    public function handle($object)
    {
        if($object instanceof OwnsSlug)
        {
            $object->sluggify();
            $object->save();
        }
    }

}