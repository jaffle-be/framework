<?php

namespace Modules\Media;

/**
 * Interface StoresMedia
 * @package Modules\Media
 */
interface StoresMedia
{
    public function images();

    public function videos();

    public function infographics();

    /**
     * @param null $type
     * @param null $size
     * @return mixed
     */
    public function getMediaFolder($type = null, $size = null);

    public function mediaStoresMultiple();

    /**
     * @param null $width
     * @param null $height
     * @return mixed
     */
    public function sizes($width = null, $height = null);

    /**
     * @param null $width
     * @param null $height
     * @return mixed
     */
    public function thumbnail($width = null, $height = null);
}
