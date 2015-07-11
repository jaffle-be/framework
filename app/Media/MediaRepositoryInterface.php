<?php namespace App\Media;

interface MediaRepositoryInterface {

    /**
     * @param array      $payload
     * @param Image $original
     *
     * @return Image|bool
     */
    public function createImage(array $payload , Image $original = null);
}