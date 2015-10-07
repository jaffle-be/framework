<?php namespace App\Media;

use Exception;

trait StoringMedia
{
    use ImageDimensionHelpers;

    public function mediaStoresMultiple()
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

    public function videos()
    {
        if($this->mediaStoresMultiple())
        {
            return $this->morphMany('App\Media\Video\Video', 'owner');
        }

        return $this->morphOne('App\Media\Video\Video', 'owner');
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

    public function getMediaFolder($size = null)
    {
        if(!property_exists(get_class($this), 'media'))
        {
            throw new Exception('Please define media attribute on your model');
        }

        $account = isset($this->attributes['account_id']) ? $this->attributes['account_id'] : app('App\Account\AccountManager')->account()->id;

        $media = str_replace('{account}', $account, $this->media);

        if(!$size)
        {
            return sprintf('%s/%d/', $media, $this->attributes['id']);
        }

        return sprintf('%s/%d/%s/', $media, $this->attributes['id'], $size);
    }

}