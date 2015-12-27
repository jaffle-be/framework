<?php

namespace Modules\Media;

use Exception;

trait ImageDimensionHelpers
{

    /**
     * Dimensions can be passed like this:
     * 150x150 to have a fixed dimension
     * 150x to have a auto resize with a max width of
     * x150 to have a auto resize with a max height of.
     *
     * @return array
     * @throws Exception
     */
    protected function dimensions($size)
    {
        if (strpos($size, 'x') === false) {
            throw new Exception('Invalid image dimension provided');
        }

        list($width, $height) = explode('x', $size, 2);

        if ($this->bothAreNull($width, $height) || $this->hasNonNumeric($width, $height)) {
            throw new Exception('Invalid image size provided');
        }

        return array($width, $height);
    }

    protected function bothAreNull($width, $height)
    {
        return empty($width) && empty($height);
    }

    protected function hasNonNumeric($width, $height)
    {
        return (!empty($width) && !is_numeric($width)) || (!empty($height) && !is_numeric($height));
    }

    protected function constraint($width, $height)
    {
        if (empty($width) || empty($height)) {
            return function ($constraint) {
                $constraint->aspectRatio();
            };
        }

        return;
    }
}
