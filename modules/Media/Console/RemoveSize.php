<?php

namespace Modules\Media\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Modules\Media\Configurator;
use Modules\Media\StoresMedia;

/**
 * Class RemoveSize
 * @package Modules\Media\Console
 */
class RemoveSize extends Command
{
    protected $signature = 'media:remove-size {size} {type=all}';

    /**
     * @var Configurator
     */
    protected $config;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new console command instance.
     * @param Configurator $config
     * @param Filesystem $files
     */
    public function __construct(Configurator $config, Filesystem $files)
    {
        $this->config = $config;

        $this->files = $files;

        parent::__construct();
    }

    public function handle()
    {
        $types = $this->config->getTypes($this->argument('type'));

        foreach ($types as $type) {
            $this->handleType($type);
        }
    }

    /**
     * @param $type
     */
    protected function handleType($type)
    {
        $entity = app($type);

        $entity->chunk(250, function ($owners) {

            $size = $this->argument('size');

            list($width, $height) = explode('x', $size, 2);

            $owners->load([
                'images',
                'images.sizes' => function ($query) use ($width, $height) {
                    $query->dimension($width, $height);
                },
            ]);

            foreach ($owners as $owner) {
                /* @var StoresMedia $owner */
                $this->handleOwner($owner, $size);
            }
        });
    }

    /**
     * $this
     * @param StoresMedia $owner
     * @param $size
     */
    public function handleOwner(StoresMedia $owner, $size)
    {
        if ($owner->mediaStoresMultiple()) {
            foreach ($owner->images as $image) {
                $this->handleImage($image);
            }
        } elseif ($owner->images) {
            $this->handleImage($owner->images);
        }

        $this->files->deleteDirectory(rtrim($this->config->getPublicPath($owner, 'images', $size), '/'));
    }

    /**
     * $owner
     * @param $image
     */
    public function handleImage($image)
    {
        foreach ($image->sizes as $size) {
            $size->delete();
        }
    }
}
