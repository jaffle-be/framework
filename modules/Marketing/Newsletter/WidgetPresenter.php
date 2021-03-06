<?php

namespace Modules\Marketing\Newsletter;

use Modules\System\Presenter\BasePresenter;

/**
 * Class WidgetPresenter
 * @package Modules\Marketing\Newsletter
 */
class WidgetPresenter extends BasePresenter
{
    /**
     * @return mixed
     */
    public function image()
    {
        if ($this->entity->manual) {
            return $this->entity->image->path;
        } else {
            return $this->entity->resource->images->first()->path;
        }
    }

    /**
     * @return mixed
     */
    public function image_left()
    {
        if ($this->entity->manual) {
            return $this->entity->imageLeft->path;
        } else {
            return $this->entity->resource->images->first()->path;
        }
    }

    /**
     * @return mixed
     */
    public function image_right()
    {
        if ($this->entity->manual) {
            return $this->entity->imageRight->path;
        } else {
            return $this->entity->otherResource->images->first()->path;
        }
    }

    /**
     * @param $locale
     * @return mixed
     */
    public function title($locale)
    {
        if ($this->entity->manual) {
            return $this->entity->translate($locale)->title;
        } else {
            return $this->entity->resource->translate($locale)->title;
        }
    }

    /**
     * @param $locale
     * @return mixed
     */
    public function title_left($locale)
    {
        if ($this->entity->manual) {
            return $this->entity->translate($locale)->title_left;
        } else {
            return $this->entity->resource->translate($locale)->title;
        }
    }

    /**
     * @param $locale
     * @return mixed
     */
    public function title_right($locale)
    {
        if ($this->entity->manual) {
            return $this->entity->translate($locale)->title_right;
        } else {
            return $this->entity->otherResource->translate($locale)->title;
        }
    }

    /**
     * @param $locale
     * @return mixed
     */
    public function text($locale)
    {
        if ($this->entity->manual) {
            return $this->entity->translate($locale)->text;
        } else {
            return $this->entity->resource->translate($locale)->text;
        }
    }

    /**
     * @param $locale
     * @return mixed
     */
    public function text_left($locale)
    {
        if ($this->entity->manual) {
            return $this->entity->translate($locale)->text_left;
        } else {
            return $this->entity->resource->translate($locale)->text;
        }
    }

    /**
     * @param $locale
     * @return mixed
     */
    public function text_right($locale)
    {
        if ($this->entity->manual) {
            return $this->entity->translate($locale)->text_right;
        } else {
            return $this->entity->otherResource->translate($locale)->text;
        }
    }
}
