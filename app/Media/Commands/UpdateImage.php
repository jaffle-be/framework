<?php namespace App\Media\Commands;

use App\Jobs\Job;
use App\Media\Image;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class UpdateImage
 *
 * @package App\Media\Commands
 */
class UpdateImage extends Job implements SelfHandling{

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
     * @return Image|bool
     */
    public function handle()
    {
        $this->image->fill($this->input);

        return $this->image->save() ? $this->image : false;
    }

}