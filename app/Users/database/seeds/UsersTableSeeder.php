<?php

use App\Users\User;
use Jaffle\Tools\Seeder;

class UsersTableSeeder extends Seeder{

    public function run()
    {
        User::create([
            'email' => 'thomas.warlop@gmail.com',
            'password' => \Hash::make('thomasthomas'),
            'confirmed' => 1
        ]);
    }

}