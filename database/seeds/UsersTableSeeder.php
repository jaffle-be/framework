<?php

use App\System\Seeder;
use App\Users\User;

class UsersTableSeeder extends Seeder{

    public function run()
    {
        User::create([
            'email' => 'thomas@digiredo.be',
            'password' => \Hash::make('thomasthomas'),
            'firstname' => 'Thomas',
            'lastname' => 'Warlop',
            'confirmed' => 1
        ]);
    }

}