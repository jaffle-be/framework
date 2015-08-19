<?php

use App\System\Country\Country;
use App\System\Seeder;
use Illuminate\Foundation\Bus\DispatchesCommands;

class CountryTableSeeder extends Seeder
{

    use DispatchesCommands;

    public function run()
    {
        $countries = file_get_contents(__DIR__ . '/countries.json');
        $countries = json_decode($countries);

        foreach($countries->data as $country)
        {
            Country::create([
                'iso_code_2' => $country->iso_code_2,
                'iso_code_3' => $country->iso_code_3,
                'en' => [
                    'name' => $country->name
                ]
            ]);
        }
    }

}