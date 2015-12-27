<?php

use Modules\Shop\Product\Category;
use Modules\Shop\Product\CategoryTranslation;
use Modules\System\Seeder;

class CategoryTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path('database/data/categories.json');

        if (file_exists($path)) {
            $data = $this->data($path);

            $this->categories($data);
        } else {
            throw new \Exception("Couldn't find categories.json file");
        }
    }

    protected function data($file)
    {
        $data = file_get_contents($file);

        $data = json_decode($data);

        return $data;
    }


    protected function categories($data)
    {
        foreach($data as $category)
        {
            $name = $category->naam;

            if(CategoryTranslation::where('name', $name)->count() == 0)
            {
                Category::create([
                    'nl' => ['name' => $name],
                    'en' => ['name' => $name],
                    'fr' => ['name' => $name],
                    'de' => ['name' => $name],
                ]);
            }
        }
    }

}