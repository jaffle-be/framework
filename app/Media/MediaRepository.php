<?php namespace App\Media;

class MediaRepository implements MediaRepositoryInterface{
    
    protected $media;

    protected $type;

    protected $images;

    public function __construct(Image $images)
    {
        $this->images = $images;
    }

    public function createImage(array $payload, Image $original = null)
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