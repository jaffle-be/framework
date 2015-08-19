<?php

use App\Account\Account;
use App\Account\Team;
use App\System\Seeder;

class TeamSeeder extends Seeder
{

    public function run()
    {
        $teller = 0;

        while ($teller < 3) {
            Team::create([
                'account_id' => 1,
                'nl'         => [
                    'name'        => $this->faker->sentence(2),
                    'description' => $this->faker->paragraph(5),
                ],
                'en'         => [
                    'name'        => $this->faker->sentence(2),
                    'description' => $this->faker->paragraph(5),
                ],
                'fr'         => [
                    'name'        => $this->faker->sentence(2),
                    'description' => $this->faker->paragraph(5),
                ],
                'de'         => [
                    'name'        => $this->faker->sentence(2),
                    'description' => $this->faker->paragraph(5),
                ],
            ]);

            $teller++;
        }

        $account = Account::find(1);
        $teams = array_flip([1, 2, 3]);

        foreach ($account->memberships as $membership) {
            $membership->teams()->attach(array_rand($teams, rand(1, 3)));
        }
    }

}