<?php namespace App\Media;

use Exception;
use InvalidArgumentException;

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

    public function infographics()
    {
        return $this->morphMany('App\Media\Infographics\Infographic', 'owner');
    }

    public function files()
    {
        return $this->morphMany('App\Media\Files\File', 'owner');
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

    public function getMediaFolder($type = null, $size = null)
    {
        $account = isset($this->attributes['account_id']) ? $this->attributes['account_id'] : app('App\Account\AccountManager')->account()->id;

        $media = str_replace('{account}', $account, $this->media);

        /** @var Configurator $config */
        $config = app('App\Media\Configurator');

        if(empty($type))
        {
            return sprintf('%s/%d/', $media, $this->attributes['id']);
        }

        if(!empty($type) && !$config->isSupportedMediaType($type))
        {
            throw new InvalidArgumentException('Need valid media type to return a proper folder');
        }

        if(!property_exists(get_class($this), 'media'))
        {
            throw new Exception('Please define media attribute on your model');
        }

        if(!$size)
        {
            return sprintf('%s/%d/%s/', $media, $this->attributes['id'], $type);
        }

        return sprintf('%s/%d/%s/%s/', $media, $this->attributes['id'], $type, $size);
    }

}