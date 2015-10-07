<?php namespace App\Media;

use App\Media\Video\Video;

class MediaRepository implements MediaRepositoryInterface{
    
    protected $images;

    protected $config;

    protected $videos;

    public function __construct(Configurator $config, Image $images, Video $videos)
    {
        $this->config = $config;

        $this->images = $images;

        $this->videos = $videos;
    }

    public function findOwner($type, $id)
    {
        if($this->config->typeExists($type))
        {
            $class = $this->config->classname($type);

            $class = new $class();

            return $class->findorFail($id);
        }
    }

    /**
     * @param StoresMedia $owner
     * @param array       $payload
     * @param Image|null  $original
     *
     * @return bool|static
     */
    public function createImage(StoresMedia $owner, array $payload)
    {
        //create image
        $image = $this->images->newInstance($payload);

        $image->owner()->associate($owner);

        //sorting is 0 indexed
        if($owner->mediaStoresMultiple())
        {
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
    public function createThumbnailImage(array $payload, Image $original = null)
    {
        //create image
        $image = $this->images->newInstance($payload);

        if($original)
        {
            $image->original()->associate($original);

            $image->account_id = $original->account_id;
        }

        $image = $image->save() ? $image : false;

        return $image;
    }

}