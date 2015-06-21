<?php namespace App\Tags;

class TagObserver {

    public function deleting(Tag $tag)
    {
        $tag->translations()->delete();
    }

}