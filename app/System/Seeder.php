<?php
namespace App\System;

use App\Media\ImageDimensionHelpers;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder as BaseSeeder;

abstract class Seeder extends BaseSeeder
{
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

            foreach ($this->image_sizes as $size) {

                list($width, $height) = $this->dimensions($size);

                $constraint = $this->constraint($width, $height);

                $this->images->cache(function ($image) use ($path, $width, $height, $constraint) {
                    $image->make($path)->resize($width, $height, $constraint);
                });
            }
        }
    }

    protected function newImage($owner, $account)
    {
        $image = rand(0, count($this->image_names) - 1);

        $this->dispatchFromArray(StoreNewImage::class, [
            'account' => $account,
            'owner'   => $owner,
            'path'    => $this->prefix . $this->image_names[$image],
            'sizes'   => $this->image_sizes,
            'seeding' => true
        ]);
    }

}