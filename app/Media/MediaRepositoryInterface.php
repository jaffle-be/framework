<?php namespace App\Media;

interface MediaRepositoryInterface {

    /**
     * @param StoresMedia $owner
     * @param array       $payload
     *
     * @return Image|bool
     */
    public function createImage(StoresMedia $owner, array $payload);

    /**
     * @param array       $payload
     * @param Image|null  $original
     *
     * @return mixed
     */
    public function createThumbnailImage(array $payload , Image $original = null);
}