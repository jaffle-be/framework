<?php namespace App\Media;

trait StoringMedia
{

    public function images()
    {
        return $this->morphMany('App\Media\Image', 'owner');
    }

    public function getMediaFolder()
    {
        if(!property_exists(get_class($this), 'media'))
        {
            throw new Exception('Please define media attribute on your model');
        }

        return sprintf('%s/%d/', $this->media, $this->attributes['id']);
    }

}