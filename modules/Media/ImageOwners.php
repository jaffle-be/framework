<?php

namespace Modules\Media;

/**
 * Class ImageOwners
 * @package Modules\Media
 */
trait ImageOwners
{
    /**
     * @param null $width
     * @param null $height
     */
    public function loadImageSizes($width = null, $height = null)
    {
        $this->load([
            'images',
            'images.sizes' => function ($query) use ($width, $height) {
                $query->dimension($width, $height);
            },
        ]);
    }
}
