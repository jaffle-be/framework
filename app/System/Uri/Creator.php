<?php namespace App\System\Uri;

use App\System\Sluggable\OwnsSlug;

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