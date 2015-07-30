<?php namespace App\Media;

use Exception;

trait ImageDimensionHelpers
{

    /**
     * Dimensions can be passed like this:
     * 150x150 to have a fixed dimension
     * 150x to have a auto resize with a max width of
     * x150 to have a auto resize with a max height of
     *
     * @return array
     * @throws Exception
     */
    protected function dimensions($size)
    {
        if(strpos($size, 'x') === false)
        {
            throw new Exception('Invalid image dimension provided');
        }

        if(starts_with($size, 'x'))
        {
            $width= null;
            $height = str_replace('x', '', $size);
        }
        else if(ends_with($size, 'x'))
        {
            $width = str_replace('x', '', $size);
            $height = null;
        }
        else{
            list($width, $height) = explode('x', $size);
        }

        if($this->bothAreNull($width, $height) || $this->hasNonNumeric($width, $height) )
        {
            throw new Exception('Invalid image size provided');
        }

        return array($width, $height);
    }

    protected function hasNonNumeric($width, $height)
    {
        return (!is_null($width) && !is_numeric($width)) || (!is_null($height) && !is_numeric($height));
    }

    protected function bothAreNull($width, $height)
    {
        return is_null($width) && is_null($height);
    }

    protected function constraint($width, $height)
    {
        if ($width === null || $height === null) {
            return function ($constraint) {
                $constraint->aspectRatio();
            };
        }

        return null;
    }


}