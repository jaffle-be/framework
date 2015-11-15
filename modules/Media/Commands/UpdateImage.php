<?php namespace Modules\Media\Commands;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Media\Image;

/**
 * Class UpdateImage
 *
 * @package Modules\Media\Commands
 */
class UpdateImage extends Job implements SelfHandling
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
     * @return Image|bool
     */
    public function handle()
    {
        $this->image->fill($this->input);

        return $this->image->save() ? $this->image : false;
    }

}