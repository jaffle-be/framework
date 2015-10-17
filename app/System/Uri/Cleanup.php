<?php namespace App\System\Uri;

use App\System\Sluggable\OwnsSlug;
use App\System\Translatable\TranslationModel;
use Illuminate\Database\Eloquent\Relations\Relation;

class Cleanup
{

    public function handle($object)
    {
        //we need to check for owns slug on the model itself,
        //or on translation model.
        //our db takes care of foreign key deletion.
        //so there is no 'eloquent.deleted' for our translation
        //if we deleted the parent.
        if($object instanceof OwnsSlug)
        {
            $object->slug->delete();
        }

        if($this->translationOwnsSlug($object))
        {
            foreach($object->translations as $translation)
            {
                $translation->slug->delete();
            }
        }
    }

    protected function translationOwnsSlug($object)
    {
        if(!method_exists($object, 'translations'))
        {
            return false;
        }

        if(!$object->translations() instanceof Relation)
        {
            return false;
        }

        if(!$instance = $object->translations()->getRelated())
        {
            return false;
        }

        if(!$instance instanceof TranslationModel)
        {
            return false;
        }
        if(!$instance instanceof OwnsSlug){
            return false;
        }

        //only return true when all previus conditions are right
        return true;
    }

}