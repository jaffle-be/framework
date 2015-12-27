<?php

use Modules\Shop\Product\Category;
use Modules\System\Seeder;

/**
 * Class CategoryTableSeeder
 */
class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (Category::count() == 0) {
            $path = base_path('database/data/categories.json');

            if (file_exists($path)) {
                $data = $this->data($path);

                $this->categories($data);
            } else {
                throw new \Exception("Couldn't find categories.json file");
            }
        }
    }

    /**
     * @param $file
     * @return mixed|string
     */
    protected function data($file)
    {
        $data = file_get_contents($file);

        $data = json_decode($data);

        return $data;
    }

    /**
     * @param $data
     */
    protected function categories($data)
    {
        foreach ($data as $category) {
            $name = $category->naam;

            Category::create([
                'nl' => ['name' => $name],
                'en' => ['name' => $name],
                'fr' => ['name' => $name],
                'de' => ['name' => $name],
            ]);
        }
    }
}
