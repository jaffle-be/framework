<?php

namespace Modules\Media;

use Modules\Media\Files\File;
use Modules\Media\Infographics\Infographic;
use Modules\Media\Video\Video;

interface MediaRepositoryInterface
{
    /**
     *
     */
    public function findOwner($type, $id);

    /**
     *
     */
    public function createImage(StoresMedia $owner, array $payload);

    /**
     *
     */
    public function createThumbnailImage(array $payload, Image $original);

    /**
     *
     */
    public function createVideo(StoresMedia $owner, array $payload);

    /**
     *
     */
    public function createInfographic(StoresMedia $owner, array $payload);

    /**
     *
     */
    public function createThumbnailInfographic(array $payload, Infographic $original);

    /**
     *
     */
    public function createFile(StoresMedia $owner, array $payload);
}
