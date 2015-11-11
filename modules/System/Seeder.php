<?php
namespace Modules\System;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder as BaseSeeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Modules\Media\Configurator;
use Modules\Media\Image;
use Modules\Media\ImageDimensionHelpers;
use Modules\Media\MediaRepository;

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
     * @var Configurator
     */
    protected $mediaConfig;

    protected $files;

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

        $this->mediaConfig = app(Configurator::class);
        $this->files = app(Filesystem::class);
        $this->repository = app(MediaRepository::class);
    }

    protected function addImages($model)
    {
        $options = ['one_image' => ['PORTFOLIO_O14A0464.jpg'], 'two_images' => ['PORTFOLIO_O14A0464.jpg', 'PORTFOLIO_IMG_0331.jpg'], 'three_images' => ['PORTFOLIO_IMG_0324.jpg', 'PORTFOLIO_IMG_0331.jpg', 'PORTFOLIO_O14A0464.jpg']];

        $images = array_rand($options, 1);

        $source = database_path('images/' . $images);

        $destination = $this->mediaConfig->getPublicPath($model, 'images');

        $this->files->copyDirectory($source, $destination);

        $files = scandir($destination);

        $files = array_filter($files, function ($file) {
            return !in_array($file, ['.', '..', '.DS_Store']);
        });

        foreach ($files as $file) {
            if ($this->files->isDirectory($destination . $file)) {
                $sizes[] = $file;
            }
        }

        foreach ($options[$images] as $name) {
            $original = $this->addMain($model, $destination, $name);
            $this->addSizes($model, $sizes, $original, $destination, $name);
        }
    }

    protected function addMain($model, $destination, $name)
    {
        $path = $destination . $name;
        $info = getimagesize($path);

        return $this->repository->createImage($model, [
            'filename'  => $name,
            'width'     => $info[0],
            'height'    => $info[1],
            'extension' => pathinfo($path, PATHINFO_EXTENSION),
            'path'      => $this->mediaConfig->getAbstractPath($model, 'images') . $name,
        ]);
    }

    protected function addSizes($model, array $sizes, $original, $destination, $name)
    {
        foreach ($sizes as $size) {
            $path = $destination . $size . '/' . $name;
            $info = getimagesize($path);

            $this->repository->createThumbnailImage([
                'filename'  => $name,
                'width'     => $info[0],
                'height'    => $info[1],
                'extension' => pathinfo($path, PATHINFO_EXTENSION),
                'path'      => $this->mediaConfig->getAbstractPath($model, 'images', $size) . $name,
            ], $original);
        }
    }

}