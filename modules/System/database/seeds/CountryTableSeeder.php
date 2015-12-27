<?php

use Modules\System\Country\Country;
use Modules\System\Seeder;

class CountryTableSeeder extends Seeder
{

    public function run()
    {
        $countries = file_get_contents(__DIR__ . '/countries.json');
        $countries = json_decode($countries);

        foreach ($countries->data as $country) {
            Country::create([
                'iso_code_2' => $country->iso_code_2,
                'iso_code_3' => $country->iso_code_3,
                'en' => [
                    'name' => $country->name,
                ],
            ]);
        }
    }
}
