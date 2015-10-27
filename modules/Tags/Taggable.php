<?php namespace Modules\Tags;

trait Taggable {

    public function tags()
    {
        return $this->morphToMany('Modules\Tags\Tag', 'taggable');
    }

}