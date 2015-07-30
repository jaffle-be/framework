<?php namespace App\Media;

use Exception;

trait StoringMedia
{
    public function images()
    {
        static $multiple;

        if($multiple === null)
        {
            $multiple = true;

            if(property_exists(get_class($this), 'mediaMultiple'))
            {
                $multiple = $this->mediaMultiple;
            }
        }

        if($multiple)
        {
            return $this->morphMany('App\Media\Image', 'owner');
        }

        return $this->morphOne('App\Media\Image', 'owner');
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