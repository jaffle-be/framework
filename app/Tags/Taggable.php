<?php namespace App\Tags;

trait Taggable {

    public function Tags()
    {
        return $this->morphToMany('App\Tags\Tag', 'taggable');
    }

}