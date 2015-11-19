<?php

use Modules\Shop\Product\Property;
use Modules\Shop\Product\PropertyOption;
use Modules\Shop\Product\PropertyUnit;
use Modules\System\Seeder;

class PropertyTableSeeder extends Seeder
{

    public function run()
    {
        factory(PropertyUnit::class)->times(35)->create();
        $units = PropertyUnit::all();
        factory(Property::class, 'numeric')->times(10)->create([
            'unit_id' => $units->random(1)->id,
        ]);
        factory(Property::class, 'boolean')->times(10)->create();
        factory(Property::class, 'float')->times(4)->create();
        factory(Property::class, 'string')->times(10)->create();

        factory(Property::class, 'options')->times(10)->create()->each(function ($property) {
            factory(PropertyOption::class)->times(rand(4, 10))->create([
                'property_id' => $property->id
            ]);
        });
    }

}