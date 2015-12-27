<?php

namespace Modules\Media;

use Modules\Media\Files\File;
use Modules\Media\Infographics\Infographic;
use Modules\Media\Video\Video;

/**
 * Interface MediaRepositoryInterface
 * @package Modules\Media
 */
interface MediaRepositoryInterface
{
    /**
     * @param $type
     * @param $id
     * @return
     */
    public function findOwner($type, $id);

    /**
     * @param StoresMedia $owner
     * @param array $payload
     * @return
     */
    public function createImage(StoresMedia $owner, array $payload);

    /**
     * @param array $payload
     * @param Image $original
     * @return
     */
    public function createThumbnailImage(array $payload, Image $original);

    /**
     * @param StoresMedia $owner
     * @param array $payload
     * @return
     */
    public function createVideo(StoresMedia $owner, array $payload);

    /**
     * @param StoresMedia $owner
     * @param array $payload
     * @return
     */
    public function createInfographic(StoresMedia $owner, array $payload);

    /**
     * @param array $payload
     * @param Infographic $original
     * @return
     */
    public function createThumbnailInfographic(array $payload, Infographic $original);

    /**
     * @param StoresMedia $owner
     * @param array $payload
     * @return
     */
    public function createFile(StoresMedia $owner, array $payload);
}
