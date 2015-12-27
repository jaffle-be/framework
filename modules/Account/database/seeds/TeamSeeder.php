<?php

use Illuminate\Database\Eloquent\Collection;
use Modules\Account\Account;
use Modules\Account\Team;
use Modules\System\Seeder;

class TeamSeeder extends Seeder
{

    public function run()
    {
        foreach ([1, 2] as $account) {
            $teller = 0;

            $teams = new Collection();

            while ($teller < 3) {
                $teams->push(Team::create([
                    'account_id' => $account,
                    'nl' => [
                        'name' => $this->faker->sentence(2),
                        'description' => $this->faker->paragraph(5),
                    ],
                    'en' => [
                        'name' => $this->faker->sentence(2),
                        'description' => $this->faker->paragraph(5),
                    ],
                    'fr' => [
                        'name' => $this->faker->sentence(2),
                        'description' => $this->faker->paragraph(5),
                    ],
                    'de' => [
                        'name' => $this->faker->sentence(2),
                        'description' => $this->faker->paragraph(5),
                    ],
                ]));

                ++$teller;
            }

            $account = Account::find($account);
            $teams = array_flip($teams->lists('id')->toArray());

            foreach ($account->memberships as $membership) {
                $membership->teams()->attach(array_rand($teams, rand(1, 3)));
            }
        }
    }
}
