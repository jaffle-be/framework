<?php

namespace Modules\Media\Image;

trait ImageModelTrait
{
    public function original()
    {
        return $this->belongsTo(get_class($this), 'original_id');
    }

    public function sizes()
    {
        return $this->hasMany(get_class($this), 'original_id');
    }

    public function thumbnail($width = null, $height = null)
    {
        if (!$this->relationLoaded('sizes')) {
            $this->load(['sizes']);
        }

        $thumbnail = $this->sizes->filter(function ($item) use ($width, $height) {
            if (!empty($width) && !empty($height)) {
                return $item->width == $width && $item->height == $height;
            }

            if (!empty($width)) {
                return $item->width == $width;
            }

            if (!empty($height)) {
                return $item->height == $height;
            }

            return false;
        })->first();

        if ($thumbnail) {
            return $thumbnail->path;
        }

        if ($image = $this->sizes->first()) {
            return $image->path;
        }
    }

    public function scopeDimension($query, $width = null, $height = null, $boolean = 'and')
    {
        $clause = function ($query) use ($width, $height) {
            if ($width) {
                $query->where('width', $width);
            }

            if ($height) {
                $query->where('height', $height);
            }
        };

        if ($boolean == 'and') {
            $query->where($clause);
        } elseif ($boolean == 'or') {
            $query->orWhere($clause);
        }
    }

    public function scopeDimensions($query, array $sizes)
    {
        $query->where(function ($query) use ($sizes) {

            foreach ($sizes as $size) {
                $width = $size[0];

                $height = isset($size[1]) ? $size[1] : null;

                $query->dimension($query, $width, $height, 'or');
            }
        });
    }
}
