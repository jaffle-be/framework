<?php

namespace Modules\System\Uri;

use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\System\Sluggable\OwnsSlug;
use Modules\System\Translatable\Translatable;
use Modules\System\Translatable\TranslationModel;

/**
 * Class Cleanup
 * @package Modules\System\Uri
 */
class Cleanup
{
    /**
     * @param $object
     */
    public function handle($object)
    {
        //we need to check for owns slug on the model itself,
        //or on translation model.
        //our db takes care of foreign key deletion.
        //so there is no 'eloquent.deleted' for our translation
        //if we deleted the parent.
        if ($object instanceof OwnsSlug) {
            $object->slug()->delete();
        }

        if(uses_trait(get_class($object), Translatable::class))
        {
            $related = $object->translations()->getRelated();

            if($related instanceof OwnsSlug)
            {
                foreach ($object->translations as $translation) {
                    $translation->slug()->delete();
                }
            }
        }
    }

}
