<?php namespace App\Media;

use App\System\Scopes\ModelAccountResource;
use Exception;

trait StoringMedia
{
    use ImageDimensionHelpers;

    protected function mediaStoresMultiple()
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

        return $multiple;
    }

    public function images()
    {
        if($this->mediaStoresMultiple())
        {
            return $this->morphMany('App\Media\Image', 'owner');
        }

        return $this->morphOne('App\Media\Image', 'owner');
    }

    public function sizes($width = null, $height = null)
    {
        $this->images()->dimension($width, $height);

        return $this->images;
    }

    //this is a shortcut method to get the thumbnail source.
    public function thumbnail($width = null, $height = null)
    {
        if($this->mediaStoresMultiple())
        {
            $image = $this->images->first();
        }
        else{
            $image = $this->images;
        }

        if($image)
        {
            return $image->thumbnail($width, $height);
        }
    }

    public function getMediaFolder()
    {
        if(!property_exists(get_class($this), 'media'))
        {
            throw new Exception('Please define media attribute on your model');
        }

        if($this instanceof ModelAccountResource)
        {
            return sprintf('%d/%s/%d/', $this->attributes['account_id'], $this->media, $this->attributes['id']);
        }

        return sprintf('%s/%d/', $this->media, $this->attributes['id']);
    }

}