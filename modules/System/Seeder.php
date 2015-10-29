<?php
namespace Modules\System;

use Exception;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder as BaseSeeder;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Modules\Media\Commands\StoreNewImage;
use Modules\Media\ImageDimensionHelpers;

abstract class Seeder extends BaseSeeder
{
    use DispatchesCommands;
    use ImageDimensionHelpers;

    /**
     * The Faker instance.
     *
     * @type Faker
     */
    protected $faker;

    protected $nl;

    protected $fr;

    protected $en;

    protected $de;

    /**
     * Build a new Seed.
     */
    public function __construct()
    {
        // Bind Faker instance if available
        if (class_exists('Faker\Factory')) {
            $this->nl = Faker::create('nl_BE');
            $this->fr = Faker::create('fr_BE');
            $this->en = Faker::create('en_US');
            $this->de = Faker::create('de_DE');
            $this->faker = $this->en;
        }
//        Model::unguard();
        \DB::disableQueryLog();
    }

    /**
     * @param $images
     * @param $sizes
     *
     * @return mixed
     */
    protected function preImageCaching()
    {
        //run images cachings.
        foreach ($this->image_names as $image) {

            $path = $this->prefix . $image;

            $media = app('Modules\Media\Configurator');

            foreach ($media->getImageSizes($this->model) as $size) {

                list($width, $height) = $this->dimensions($size);

                $constraint = $this->constraint($width, $height);

                $this->images->cache(function ($image) use ($path, $width, $height, $constraint) {
                    $image->make($path)->resize($width, $height, $constraint);
                });
            }
        }
    }

    protected function validateSeederModel()
    {
        if(!isset($this->image_names))
        {
            throw new Exception('need to set image_names when calling this function');

        }

        if(!isset($this->model))
        {
            throw new Exception('need to set the model when calling this function');

        }

        if(!isset($this->prefix))
        {
            throw new Exception('need to set prefix when calling this function');

        }
    }

    protected function newImage($owner, $account = null)
    {
        $this->validateSeederModel();
        $image = rand(0, count($this->image_names) - 1);

        $this->dispatchFromArray(StoreNewImage::class, [
            'account' => $account,
            'owner'   => $owner,
            'path'    => $this->prefix . $this->image_names[$image],
        ]);
    }

}