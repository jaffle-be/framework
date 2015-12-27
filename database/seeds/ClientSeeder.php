<?php

use Modules\Account\Client;
use Modules\System\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $accounts = [1, 2];

        foreach ($accounts as $account) {
            $teller = 0;

            while ($teller < 15) {
                Client::create([
                    'account_id' => $account,
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
}
