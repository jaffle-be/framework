<?php namespace App\System\Uri;

use App\System\Sluggable\OwnsSlug;

class Cleanup
{

    public function handle($object)
    {
        if($object instanceof OwnsSlug)
        {
            $object->slug->delete();
        }
    }

}