<?php

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use Modules\Media\Commands\StoreNewImage;
use Modules\Shop\Product\Brand;
use Modules\System\Seeder;

class BrandTableSeeder extends Seeder
{

    use DispatchesJobs;

    /**
     * @var Hasher
     */
    protected $hasher;

    /**
     * @var Filesystem
     */
    protected $files;

    public function __construct(Hasher $hasher, Filesystem $files)
    {
        parent::__construct();

        $this->hasher = $hasher;

        $this->files = $files;
    }

    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (Brand::count() == 0) {
            $path = base_path('database/data/brands.json');

            if (file_exists($path)) {
                $data = $this->data($path);

                $this->brands($data->brands);
            } else {
                throw new \Exception("Couldn't find brands.json file");
            }
        }
    }

    /**
     * @return mixed|string
     */
    protected function data($file)
    {
        $data = file_get_contents($file);

        $data = json_decode($data);

        return $data;
    }

    protected function brands($brands)
    {
        foreach ($brands as $brand) {
            $file = $this->image($brand->name, $brand->brands);

            $existing = Brand::create([
                'nl' => [
                    'name' => $brand->name,
                ],
                'en' => [
                    'name' => $brand->name,
                ],
                'fr' => [
                    'name' => $brand->name,
                ],
                'de' => [
                    'name' => $brand->name,
                ],
            ]);

            $this->dispatch(new StoreNewImage(null, $existing, $file));
        }
    }

    protected function categories($categories)
    {
        foreach ($categories as $category) {
            echo $category->naam;
        }
    }

    protected function image($name, $url)
    {
        $extension = last(explode('.', $url));

        $name = str_replace('/', '', Str::slug($name));

        $path = base_path("database/images/brands/$name.$extension");

        if (!file_exists($path)) {
            $this->error('need to publish images for brands');
        }

        return $path;
    }
}
