<?php

namespace Modules\Media;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use InvalidArgumentException;
use Modules\System\Scopes\ModelAccountResource;

/**
 * Class StoringMedia
 * @package Modules\Media
 */
trait StoringMedia
{
    use ImageDimensionHelpers;

    /**
     * @return bool
     */
    public function mediaStoresMultiple()
    {
        static $multiple;

        if ($multiple === null) {
            $multiple = true;

            if (property_exists(get_class($this), 'mediaMultiple')) {
                $multiple = $this->mediaMultiple;
            }
        }

        return $multiple;
    }

    public function images()
    {
        if ($this->mediaStoresMultiple()) {
            return $this->morphMany('Modules\Media\Image', 'owner');
        }

        return $this->morphOne('Modules\Media\Image', 'owner');
    }

    public function videos()
    {
        if ($this->mediaStoresMultiple()) {
            return $this->morphMany('Modules\Media\Video\Video', 'owner');
        }

        return $this->morphOne('Modules\Media\Video\Video', 'owner');
    }

    public function infographics()
    {
        return $this->morphMany('Modules\Media\Infographics\Infographic', 'owner');
    }

    public function files()
    {
        return $this->morphMany('Modules\Media\Files\File', 'owner');
    }

    /**
     * @param null $width
     * @param null $height
     * @return mixed
     */
    public function sizes($width = null, $height = null)
    {
        $this->images()->dimension($width, $height);

        return $this->images;
    }

    //this is a shortcut method to get the thumbnail source.
    /**
     * @param null $width
     * @param null $height
     * @return mixed
     */
    public function thumbnail($width = null, $height = null)
    {
        if ($this->mediaStoresMultiple()) {
            $image = $this->images->first();
        } else {
            $image = $this->images;
        }

        if ($image) {
            return $image->thumbnail($width, $height);
        }
    }

    /**
     * @param null $type
     * @param null $size
     * @return string
     * @throws Exception
     */
    public function getMediaFolder($type = null, $size = null)
    {
        if (uses_trait($this, ModelAccountResource::class)) {
            $account = isset($this->attributes['account_id']) ? $this->attributes['account_id'] : app('Modules\Account\AccountManager')->account()->id;

            $media = str_replace('{account}', $account, $this->media);
        } else {
            $media = $this->media;
        }

        /** @var Configurator $config */
        $config = app('Modules\Media\Configurator');

        if (empty($type)) {
            return sprintf('%s/%d/', $media, $this->attributes['id']);
        }

        if (! empty($type) && ! $config->isSupportedMediaType($type)) {
            throw new InvalidArgumentException('Need valid media type to return a proper folder');
        }

        if (! property_exists(get_class($this), 'media')) {
            throw new Exception('Please define media attribute on your model');
        }

        if (! $size) {
            return sprintf('%s/%d/%s/', $media, $this->attributes['id'], $type);
        }

        return sprintf('%s/%d/%s/%s/', $media, $this->attributes['id'], $type, $size);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeHasImages(Builder $builder)
    {
        /** @var MorphOne $relation */
        $relation = $this->images();

        $key = $this->getTable().'.'.$this->getKeyName();

        $from = $relation->getQuery()->getQuery()->from;

        $builder->join($from, function ($join) use ($relation, $key) {
            $join->where($relation->getMorphType(), '=', $relation->getMorphClass());
            $join->on($relation->getForeignKey(), '=', $key);
        });

        return $builder;
    }
}
