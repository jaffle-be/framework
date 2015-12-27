<?php

namespace Modules\Media\Commands;

use App\Jobs\Job;
use Modules\Media\Image;

/**
 * Class UpdateImage.
 */
class UpdateImage extends Job
{
    /**
     * @var Image
     */
    protected $image;

    /**
     * @var array
     */
    protected $input;

    /**
     * @param Image $image
     * @param array $input
     */
    public function __construct(Image $image, array $input)
    {
        $this->image = $image;
        $this->input = $input;
    }

    /**
     *
     */
    public function handle()
    {
        $this->image->fill($this->input);

        return $this->image->save() ? $this->image : false;
    }
}
