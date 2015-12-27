<?php

namespace Modules\Media;

use Modules\Media\Files\File;
use Modules\Media\Infographics\Infographic;
use Modules\Media\Video\Video;

interface MediaRepositoryInterface
{
    /**
     *
     *
     *
     * @return StoresMedia
     */
    public function findOwner($type, $id);

    /**
     *
     *
     *
     * @return Image|bool
     */
    public function createImage(StoresMedia $owner, array $payload);

    /**
     *
     *
     *
     * @return Image|bool
     */
    public function createThumbnailImage(array $payload, Image $original);

    /**
     *
     *
     *
     * @return Video|bool
     */
    public function createVideo(StoresMedia $owner, array $payload);

    /**
     *
     *
     *
     * @return Image|bool
     */
    public function createInfographic(StoresMedia $owner, array $payload);

    /**
     *
     *
     *
     * @return Infographic|bool
     */
    public function createThumbnailInfographic(array $payload, Infographic $original);

    /**
     *
     *
     *
     * @return File|bool
     */
    public function createFile(StoresMedia $owner, array $payload);
}
