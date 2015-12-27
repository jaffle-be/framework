<?php

namespace Modules\Media;

trait ImageOwners
{

    public function loadImageSizes($width = null, $height = null)
    {
        $this->load([
            'images',
            'images.sizes' => function ($query) use ($width, $height) {
                $query->dimension($width, $height);
            }
        ]);
    }
}
