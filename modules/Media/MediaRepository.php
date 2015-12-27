<?php

namespace Modules\Media;

use InvalidArgumentException;
use Modules\Media\Files\File;
use Modules\Media\Infographics\Infographic;
use Modules\Media\Video\Video;

class MediaRepository implements MediaRepositoryInterface
{
    protected $images;

    protected $config;

    protected $videos;

    protected $infographics;

    protected $files;

    public function __construct(Configurator $config, Image $images, Video $videos, Infographic $infographics, File $files)
    {
        $this->config = $config;

        $this->images = $images;

        $this->videos = $videos;

        $this->infographics = $infographics;

        $this->files = $files;
    }

    public function findOwner($type, $id)
    {
        if ($this->config->isSupportedMediaOwner($type)) {
            $class = $this->config->classname($type);

            $class = new $class();

            return $class->findorFail($id);
        }

        throw new InvalidArgumentException('Invalid owner type provided');
    }

    /**
     * @param StoresMedia $owner
     * @param array       $payload
     *
     * @return bool|static
     */
    public function createImage(StoresMedia $owner, array $payload)
    {
        //create image
        $image = $this->images->newInstance($payload);

        $image->owner()->associate($owner);

        //sorting is 0 indexed
        if ($owner->mediaStoresMultiple()) {
            $image->sort = $owner->images->count();
        }

        return $image->save() ? $image : false;
    }

    public function createVideo(StoresMedia $owner, array $payload)
    {
        $video = $this->videos->newInstance($payload);

        $video->owner()->associate($owner);

        $video->sort = $owner->videos->count();

        return $video->save() ? $video : false;
    }

    /**
     * @param array      $payload
     * @param Image|null $original
     *
     * @return mixed
     */
    public function createThumbnailImage(array $payload, Image $original)
    {
        //create image
        $image = $this->images->newInstance($payload);

        if ($original) {
            $image->original()->associate($original);

            $image->account_id = $original->account_id;
        }

        $image = $image->save() ? $image : false;

        return $image;
    }

    /**
     * @param StoresMedia $owner
     * @param array       $payload
     *
     * @return Image|bool
     */
    public function createInfographic(StoresMedia $owner, array $payload)
    {
        //create infographic
        $graphic = $this->infographics->newInstance($payload);

        $graphic->owner()->associate($owner);

        $locale_id = $payload['locale_id'];

        $graphic->sort = $owner->infographics->filter(function ($item) use ($locale_id) {
            return $item->locale_id == $locale_id;
        })->count();

        return $graphic->save() ? $graphic : false;
    }

    /**
     * @param array            $payload
     * @param Infographic|null $original
     *
     * @return Infographic|bool
     */
    public function createThumbnailInfographic(array $payload, Infographic $original)
    {
        //create image
        $graphic = $this->infographics->newInstance($payload);

        if ($original) {
            $graphic->original()->associate($original);

            $graphic->account_id = $original->account_id;

            $graphic->locale_id = $original->locale_id;
        }

        $graphic = $graphic->save() ? $graphic : false;

        return $graphic;
    }

    /**
     * @param StoresMedia $owner
     * @param array       $payload
     *
     * @return File|bool
     */
    public function createFile(StoresMedia $owner, array $payload)
    {
        $file = $this->files->newInstance($payload);

        $file->owner()->associate($owner);

        $locale_id = $payload['locale_id'];

        $file->sort = $owner->files->filter(function ($item) use ($locale_id) {
            return $item->locale_id == $locale_id;
        })->count();

        return $file->save() ? $file : false;
    }
}
