<?php namespace App\Media;

use App\Media\Video\Video;

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
     * @return Image|bool
     */
    public function createThumbnailImage(array $payload , Image $original = null);

    /**
     * @param StoresMedia $owner
     * @param array       $payload
     *
     * @return Video|bool
     */
    public function createVideo(StoresMedia $owner, array $payload);
}