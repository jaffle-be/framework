<?php namespace Modules\Tags;

class TagObserver {

    public function deleting(Tag $tag)
    {
        $tag->translations()->delete();
    }

}