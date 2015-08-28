<?php namespace App\Media;

interface StoresMedia {

    public function images();

    public function getMediaFolder();

    public function mediaStoresMultiple();

    public function sizes($width = null, $height = null);

    public function thumbnail($width = null, $height = null);

}