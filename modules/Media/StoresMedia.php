<?php namespace Modules\Media;

interface StoresMedia {

    public function images();

    public function videos();

    public function infographics();

    public function getMediaFolder($type = null, $size = null);

    public function mediaStoresMultiple();

    public function sizes($width = null, $height = null);

    public function thumbnail($width = null, $height = null);

}