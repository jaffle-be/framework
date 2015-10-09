<?php namespace App\Media;

use App\Media\Files\File;
use App\Media\Infographics\Infographic;
use App\Media\Video\Video;

interface MediaRepositoryInterface {

    /**
     * @param $type
     * @param $id
     *
     * @return StoresMedia
     */
    public function findOwner($type, $id);

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

    /**
     * @param StoresMedia $owner
     * @param array       $payload
     *
     * @return Image|bool
     */
    public function createInfographic(StoresMedia $owner, array $payload);

    /**
     * @param array       $payload
     * @param Infographic|null  $original
     *
     * @return Infographic|bool
     */
    public function createThumbnailInfographic(array $payload , Infographic $original = null);


    /**
     * @param StoresMedia $owner
     * @param array       $payload
     *
     * @return File|bool
     */
    public function createFile(StoresMedia $owner, array $payload);

}