<?php

use Modules\System\Seeder;
use Modules\Users\User;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email' => 'thomas@digiredo.be',
            'password' => \Hash::make('thomasthomas'),
            'firstname' => 'Thomas',
            'lastname' => 'Warlop',
            'confirmed' => 1,
        ]);
    }
}
