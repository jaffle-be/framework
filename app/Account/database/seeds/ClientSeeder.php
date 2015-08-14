<?php

use App\Account\Client;
use Jaffle\Tools\Seeder;

class ClientSeeder extends Seeder
{

    public function run()
    {
        $teller = 0;

        while ($teller < 15) {
            Client::create([
                'account_id' => 1,
                'name'       => $this->faker->userName,
                'website'    => $this->faker->url,
                'nl'         => [

                    'description' => $this->faker->paragraph(5),
                ],
                'en'         => [
                    'description' => $this->faker->paragraph(5),
                ],
                'fr'         => [
                    'description' => $this->faker->paragraph(5),
                ],
                'de'         => [
                    'description' => $this->faker->paragraph(5),
                ],
            ]);

            $teller++;
        }

    }

}