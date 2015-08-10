<?php namespace App\Tags;

trait Taggable {

    public function tags()
    {
        return $this->morphToMany('App\Tags\Tag', 'taggable');
    }

}